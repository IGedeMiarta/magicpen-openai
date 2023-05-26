<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\LicenseController;
use App\Services\Statistics\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Orhanerday\OpenAi\OpenAi;
use App\Models\SubscriptionPlan;
use App\Models\Transcript;
use App\Models\Workbook;
use App\Models\User;
use Carbon\Carbon;


class TranscribeController extends Controller
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
        $projects = Workbook::where('user_id', auth()->user()->id)->get();

        return view('user.transcribe.index', compact('projects'));
    }


    /**
	*
	* Process Davinci Code
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function process(Request $request) 
    {
        if ($request->ajax()) {

            $open_ai = new OpenAi(config('services.openai.key'));  
            
            $plan = SubscriptionPlan::where('id', auth()->user()->plan_id)->first();
            $plan_type = (Auth::user()->group == 'subscriber') ? 'paid' : 'free';

            # Count minutes based on vendor requirements
            $audio_length = ((float)request('audiolength') / 60);    
            $audio_length = number_format((float)$audio_length, 3, '.', '');
 
            # Check if user has minutes available to proceed
            if ((Auth::user()->available_minutes + Auth::user()->available_minutes_prepaid) < $audio_length) {
                $data['status'] = 'error';
                $data['message'] = __('Not enough available minutes to process. Subscribe or Top up to get more');
                return $data;
            } else {
                $this->updateBalance($audio_length);
            } 

            $upload = $this->user->upload();
            if (!$upload['status']) return;  

            if (request()->has('audiofile')) {
        
                $audio = request()->file('audiofile');
                $format = $audio->getClientOriginalExtension();
                $file_name = $audio->getClientOriginalName();
                $size = $audio->getSize();
                $file_size = $this->formatBytes($size);
                $name = Str::random(10) . $format;

                
                if ($size > (config('settings.whisper_max_audio_size') * 1048576)) {
                    $data['status'] = 'error';
                    $data['message'] = __('File is too large, maximum allowed audio file size is:') . config('settings.whisper_max_audio_size') . 'MB';
                    return $data;
                } 
                
                if (config('settings.whisper_default_storage') == 'local') {
                    $audio_url = $audio->store('transcribe','public');
                } elseif (config('settings.whisper_default_storage') == 'aws') {
                    Storage::disk('s3')->put($name, $request->audiofile, 'public');
                    $audio_url = Storage::disk('s3')->url($name);
                } elseif (config('settings.whisper_default_storage') == 'wasabi') {
                    Storage::disk('wasabi')->put($name, $request->audiofile);
                    $audio_url = Storage::disk('wasabi')->url($name);
                }
            }

             # Audio Format
             if ($format == 'mp3') {
                $audio_type = 'audio/mpeg';
            } elseif ($format == 'ogg') {
                $audio_type = 'audio/ogg';
            } elseif($format == 'wav') {
                $audio_type = 'audio/wav';
            } elseif($format == 'webm') {
                $audio_type = 'audio/webm';
            }
          
            $file =  curl_file_create($audio_url);

            if (request('task') == 'transcribe') {
              
                $complete = $open_ai->transcribe([
                    'model' => 'whisper-1',
                    'file' => $file,
                    'prompt' => request('description'),
                    'language' => request('language')
                ]);
            
            } else {

                $complete = $open_ai->translate([
                    'model' => 'whisper-1',
                    'file' => $file,
                    'prompt' => request('description'),
                ]);
            } 

            $response = json_decode($complete , true);

            if (isset($response['text'])) {

                $text = $response['text'];

                if ($plan) {
                    if (is_null($plan->whisper_storage_days)) {
                        if (config('settings.whisper_default_duration') == 0) {
                            $expiration = Carbon::now()->addDays(18250);
                        } else {
                            $expiration = Carbon::now()->addDays(config('settings.whisper_default_duration'));
                        }                            
                    } else {
                        if ($plan->whisper_storage_days == 0) {
                            $expiration = Carbon::now()->addDays(18250);
                        } else {
                            $expiration = Carbon::now()->addDays($plan->whisper_storage_days);
                        }
                    }
                } else {
                    if (config('settings.whisper_default_duration') == 0) {
                        $expiration = Carbon::now()->addDays(18250);
                    } else {
                        $expiration = Carbon::now()->addDays(config('settings.whisper_default_duration'));
                    } 
                }

                $words = count(explode(' ', ($text)));
                    
                $transcript = new Transcript();
                $transcript->user_id = auth()->user()->id;
                $transcript->transcript = $text;
                $transcript->title = request('document');
                $transcript->workbook = request('project');
                $transcript->description = request('description');
                $transcript->task = request('task');
                $transcript->format = $format;
                $transcript->words = $words;
                $transcript->size = $file_size;
                $transcript->file_name = $file_name;
                $transcript->temp_name = $name;
                $transcript->length = request('audiolength');
                $transcript->plan_type = $plan_type;
                $transcript->url = $audio_url;
                $transcript->audio_type = $audio_type;
                $transcript->storage = config('settings.whisper_default_storage');
                $transcript->expires_at = $expiration;
                $transcript->save();
    
                $data['text'] = $text;
                $data['status'] = 'success';
                $data['url'] = (config('settings.whisper_default_storage') == 'local') ? URL::asset($audio_url) : $audio_url;
                $data['id'] = $transcript->id;
                $data['old'] = auth()->user()->available_minutes + auth()->user()->available_minutes_prepaid;
                $data['current'] = auth()->user()->available_minutes + auth()->user()->available_minutes_prepaid - floor($audio_length);
                return $data; 

            } else {

                if (isset($response['error']['message'])) {
                    $message = $response['error']['message'];
                } else {
                    $message = __('There is an issue with your openai account settings');
                }

                $data['status'] = 'error';
                $data['message'] = $message;
                return $data;
            }
           
        }
	}


    /**
	*
	* Update user minutes balance
	* @param - total words generated
	* @return - confirmation
	*
	*/
    public function updateBalance($minutes) {

        $user = User::find(Auth::user()->id);

        if (Auth::user()->available_minutes > $minutes) {

            $total_minutes = Auth::user()->available_minutes - $minutes;
            $user->available_minutes = ($total_minutes < 0) ? 0 : $total_minutes;

        } elseif (Auth::user()->available_minutes_prepaid > $minutes) {

            $total_minutes_prepaid = Auth::user()->available_minutes_prepaid - $minutes;
            $user->available_minutes_prepaid = ($total_minutes_prepaid < 0) ? 0 : $total_minutes_prepaid;

        } elseif ((Auth::user()->available_minutes + Auth::user()->available_minutes_prepaid) == $minutes) {

            $user->available_minutes = 0;
            $user->available_minutes_prepaid = 0;

        } else {

            $remaining = $minutes - Auth::user()->available_minutes;
            $user->available_minutes = 0;

            $used = Auth::user()->available_minutes_prepaid - $remaining;
            $user->available_minutes_prepaid = ($used < 0) ? 0 : $used;

        }

        $user->update();

    }


    /**
	*
	* Save changes
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function save(Request $request) 
    {
        if ($request->ajax()) {

            $verify = $this->api->verify_license();
            if($verify['status']!=true){return false;}

            $transcript = Transcript::where('id', request('id'))->first(); 

            if ($transcript->user_id == Auth::user()->id){

                $transcript->transcript = $request->text;
                $transcript->title = $request->title;
                $transcript->save();

                $data['status'] = 'success';
                return $data;  
    
            } else{

                $data['status'] = 'error';
                return $data;
            }  
        }
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


    public function formatBytes($bytes, $precision = 2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    
        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        $bytes /= pow(1024, $pow);
    
        return round($bytes, $precision) . ' ' . $units[$pow]; 
    }

}
