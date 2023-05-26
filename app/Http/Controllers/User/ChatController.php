<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\LicenseController;
use App\Services\Statistics\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Orhanerday\OpenAi\OpenAi;
use App\Models\SubscriptionPlan;
use App\Models\Code;
use App\Models\User;


class ChatController extends Controller
{
    private $api;
    private $user;

    public function __construct()
    {
        $this->api = new LicenseController();
        $this->user = new UserService();
    }

    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if (session()->has('messages')) {
            session()->forget('messages');
        }
        
        return view('user.chat.index');
    }


    /**
	*
	* Process Chat
	* @param - file id in DB
	* @return - confirmation
	*
	*/
    public function generateChat(Request $request) 
    {
        return response()->stream(function () {

            $open_ai = new OpenAi(config('services.openai.key'));
            $messages = session()->get('messages');
            $text = "";
            $opts = [
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
                'temperature' => 1.0,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
                'stream' => true
            ];

            $upload = $this->user->upload();
            if (!$upload['status']) return;  

            $complete = $open_ai->chat($opts, function ($curl_info, $data) use (&$text) {
                if ($obj = json_decode($data) and $obj->error->message != "") {
                    error_log(json_encode($obj->error->message));
                } else {
                    echo $data;
               
                    $clean = str_replace("data: ", "", $data);
                    $arr = json_decode($clean, true);
                   
                    if ($data != "data: [DONE]\n\n" and isset($arr["choices"][0]["delta"]["content"])) {
                        $text .= $arr["choices"][0]["delta"]["content"];
                    }
                }

                echo PHP_EOL;
                ob_flush();
                flush();
                return strlen($data);
            });

            # Update credit balance
            $words = count(explode(' ', ($text)));
            $this->updateBalance($words);            
      
            $messages[] = ['role' => 'assistant', 'content' => $text];
            request()->session()->put('messages', $messages);
           
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
        ]);
        
    }


    /**
	*
	* Process Input Text
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function process(Request $request) 
    {
        $messages = $request->session()->get('messages', [
            ['role' => 'system', 'content' => 'You are a very helpful chat assistant. Answer as concisely as possible.']
        ]);
        
        $messages[] = ['role' => 'user', 'content' => $request->input('message')];

        # Check if user has access to ai chat feature
        if (auth()->user()->group == 'user') {
            if (config('settings.chat_feature_user') != 'allow') {
                $status = 'error';
                $message = __('AI Chat feature is not available for your account, subscribe to get access');
                return response()->json(['status' => $status, 'message' => $message]);
            }
        } elseif (!is_null(auth()->user()->group)) {
            $plan = SubscriptionPlan::where('id', auth()->user()->plan_id)->first();
            if ($plan) {
                if (!$plan->transcribe_feature) {
                    $status = 'error';
                    $message = __('AI Chat feature is not available for your subscription plan');
                    return response()->json(['status' => $status, 'message' => $message]);
                }
            }
        }             

        # Check if user has sufficient words available to proceed
        $balance = auth()->user()->available_words + auth()->user()->available_words_prepaid;
        $words = count(explode(' ', ($request->input('message'))));
        if ($balance <= 0) {
            $status = 'error';
            $message = __('You do not have any words left to proceed with your next chat message request, subscribe or top up to get more words');
            return response()->json(['status' => $status, 'message' => $message]);
        } elseif ($balance < $words) {
            $status = 'error';
            $message = __('You do not have sufficient words left to proceed with your next chat message request, subscribe or top up to get more words');
            return response()->json(['status' => $status, 'message' => $message]);
        }

        
        $request->session()->put('messages', $messages);

        return response()->json(['status' => 'success', 'old'=> $balance, 'current' => ($balance - $words)]);

	}


    /**
	*
	* Clear Session
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function clear(Request $request) 
    {
        if (session()->has('messages')) {
            session()->forget('messages');
        }

        return response()->json(['status' => 'success']);
	}


    /**
	*
	* Save chat conversation 
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function save(Request $request) 
    {
        if ($request->ajax()) {

            $verify = $this->api->verify_license();
            if($verify['status']!=true){return false;}

            $document = Code::where('id', request('id'))->first(); 

            if ($document->user_id == Auth::user()->id){

                $document->code = $request->text;
                $document->title = $request->title;
                $document->save();

                $data['status'] = 'success';
                return $data;  
    
            } else{

                $data['status'] = 'error';
                return $data;
            }  

            //     // $code = new Chat();
        //     // $code->user_id = auth()->user()->id;
        //     // $code->save();

        //     // $data['text'] = $text;
        //     // $data['status'] = 'success';
        //     // $data['id'] = $code->id;
        //     // $data['old'] = auth()->user()->available_words + auth()->user()->available_words_prepaid;
        //     // $data['current'] = auth()->user()->available_words + auth()->user()->available_words_prepaid - $tokens;
        //     // return $data;
        }

        if (session()->has('messages')) {
            session()->forget('messages');
        }

        return response()->json(['status' => 'success']);
	}


    /**
	*
	* Update user word balance
	* @param - total words generated
	* @return - confirmation
	*
	*/
    public function updateBalance($words) {

        $user = User::find(Auth::user()->id);

        if (Auth::user()->available_words > $words) {

            $total_words = Auth::user()->available_words - $words;
            $user->available_words = ($total_words < 0) ? 0 : $total_words;

        } elseif (Auth::user()->available_words_prepaid > $words) {

            $total_words_prepaid = Auth::user()->available_words_prepaid - $words;
            $user->available_words_prepaid = ($total_words_prepaid < 0) ? 0 : $total_words_prepaid;

        } elseif ((Auth::user()->available_words + Auth::user()->available_words_prepaid) == $words) {

            $user->available_words = 0;
            $user->available_words_prepaid = 0;

        } else {

            $remaining = $words - Auth::user()->available_words;
            $user->available_words = 0;

            $prepaid_left = Auth::user()->available_words_prepaid - $remaining;
            $user->available_words_prepaid = ($prepaid_left < 0) ? 0 : $prepaid_left;

        }

        $user->update();

        return true;
    }


     /**
	*
	* Process media file
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function view(Request $request) 
    {
        if ($request->ajax()) {

            $verify = $this->user->verify_license();
            if($verify['status']!=true){return false;}

            $image = Image::where('id', request('id'))->first(); 

            if ($image) {
                if ($image->user_id == Auth::user()->id){

                    $data['status'] = 'success';
                    $data['url'] = URL::asset($image->image);
                    return $data;  
        
                } else{
    
                    $data['status'] = 'error';
                    $data['message'] = __('There was an error while retrieving this image');
                    return $data;
                }  
            } else {
                $data['status'] = 'error';
                $data['message'] = __('Image was not found');
                return $data;
            }
            
        }
	}


    /**
	*
	* Delete File
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function delete(Request $request) 
    {
        if ($request->ajax()) {

            $verify = $this->user->verify_license();
            if($verify['status']!=true){return false;}

            $image = Image::where('id', request('id'))->first(); 

            if ($image->user_id == auth()->user()->id){

                $image->delete();

                $data['status'] = 'success';
                return $data;  
    
            } else{

                $data['status'] = 'error';
                $data['message'] = __('There was an error while deleting the image');
                return $data;
            }  
        }
	}

}
