<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Vendor;
use App\Models\Voice;
use DB;


class DavinciConfigController extends Controller
{
    /**
     * Display TTS configuration settings
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::orderBy('languages.language', 'asc')->get();

        # Set Voice Types
        $voiceover_languages = DB::table('voices')
            ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
            ->join('voiceover_languages', 'voices.language_code', '=', 'voiceover_languages.language_code')
            ->where('vendors.enabled', '1')
            ->where('voices.status', 'active')
            ->select('voiceover_languages.id', 'voiceover_languages.language', 'voices.language_code', 'voiceover_languages.language_flag')                
            ->distinct()
            ->orderBy('voiceover_languages.language', 'asc')
            ->get();

        $voices = DB::table('voices')
            ->join('vendors', 'voices.vendor_id', '=', 'vendors.vendor_id')
            ->where('vendors.enabled', '1')
            ->where('voices.status', 'active')
            ->orderBy('voices.voice_type', 'desc')
            ->orderBy('voices.voice', 'asc')
            ->get();

        return view('admin.davinci.configuration.index', compact('languages', 'voiceover_languages', 'voices'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'default-model-admin' => 'required',
            'language' => 'required',
            'tone' => 'required',
            'creativity' => 'required',
            'templates-admin' => 'required',
            'max-results-admin' => 'required|integer',
            'default-model-user' => 'required',
            'free-tier-words' => 'required|integer',
            'free-tier-images' => 'required|integer',
            'image-feature-user' => 'required',
            'max-results-user' => 'required|integer',
            'templates-user' => 'required',
        ]);    

        $this->storeConfiguration('DAVINCI_SETTINGS_DEFAULT_STORAGE', request('default-storage'));
        $this->storeConfiguration('DAVINCI_SETTINGS_DEFAULT_DURATION', request('default-duration'));
        $this->storeConfiguration('DAVINCI_SETTINGS_DEFAULT_MODEL_ADMIN', request('default-model-admin'));
        $this->storeConfiguration('DAVINCI_SETTINGS_DEFAULT_MODEL_USER', request('default-model-user'));
        $this->storeConfiguration('DAVINCI_SETTINGS_DEFAULT_LANGUAGE', request('language'));
        $this->storeConfiguration('DAVINCI_SETTINGS_TONE_DEFAULT_STATE', request('tone'));
        $this->storeConfiguration('DAVINCI_SETTINGS_CREATIVITY_DEFAULT_STATE', request('creativity'));
        $this->storeConfiguration('DAVINCI_SETTINGS_TEMPLATES_ACCESS_ADMIN', request('templates-admin'));
        $this->storeConfiguration('DAVINCI_SETTINGS_TEMPLATES_ACCESS_USER', request('templates-user'));
        $this->storeConfiguration('DAVINCI_SETTINGS_FREE_TIER_WORDS', request('free-tier-words'));
        $this->storeConfiguration('DAVINCI_SETTINGS_FREE_TIER_IMAGES', request('free-tier-images'));
        $this->storeConfiguration('DAVINCI_SETTINGS_IMAGE_FEATURE_USER', request('image-feature-user'));
        $this->storeConfiguration('DAVINCI_SETTINGS_CODE_FEATURE_USER', request('code-feature-user'));
        $this->storeConfiguration('DAVINCI_SETTINGS_CHAT_FEATURE_USER', request('chat-feature-user'));
        $this->storeConfiguration('DAVINCI_SETTINGS_VOICEOVER_FEATURE_USER', request('voiceover-feature-user'));
        $this->storeConfiguration('DAVINCI_SETTINGS_WHISPER_FEATURE_USER', request('whisper-feature-user'));
        $this->storeConfiguration('DAVINCI_SETTINGS_MAX_RESULTS_LIMIT_ADMIN', request('max-results-admin'));
        $this->storeConfiguration('DAVINCI_SETTINGS_MAX_RESULTS_LIMIT_USER', request('max-results-user'));
        $this->storeConfiguration('OPENAI_SECRET_KEY', request('secret-key'));

        $this->storeConfiguration('DAVINCI_SETTINGS_VOICEOVER_ENABLE_AZURE', request('enable-azure'));
        $this->storeConfiguration('DAVINCI_SETTINGS_VOICEOVER_ENABLE_GCP', request('enable-gcp'));
        $this->storeConfiguration('DAVINCI_SETTINGS_VOICEOVER_SSML_EFFECT', request('set-ssml-effects'));
        $this->storeConfiguration('DAVINCI_SETTINGS_VOICEOVER_MAX_CHAR_LIMIT', request('set-max-chars'));
        $this->storeConfiguration('DAVINCI_SETTINGS_VOICEOVER_MAX_VOICE_LIMIT', request('set-max-voices'));
        $this->storeConfiguration('DAVINCI_SETTINGS_VOICEOVER_DEFAULT_STORAGE', request('set-storage-option'));
        $this->storeConfiguration('DAVINCI_SETTINGS_VOICEOVER_DEFAULT_DURATION', request('voiceover-default-duration'));
        $this->storeConfiguration('DAVINCI_SETTINGS_VOICEOVER_DEFAULT_LANGUAGE', request('language'));
        $this->storeConfiguration('DAVINCI_SETTINGS_VOICEOVER_DEFAULT_VOICE', request('voice'));
        $this->storeConfiguration('DAVINCI_SETTINGS_VOICEOVER_FREE_TIER_WELCOME_CHARS', request('set-free-chars'));

        $this->storeConfiguration('DAVINCI_SETTINGS_WHISPER_MAX_AUDIO_SIZE', request('set-max-audio-size'));
        $this->storeConfiguration('DAVINCI_SETTINGS_WHISPER_DEFAULT_STORAGE', request('set-whisper-storage-option'));
        $this->storeConfiguration('DAVINCI_SETTINGS_WHISPER_DEFAULT_DURATION', request('whisper-default-duration'));
        $this->storeConfiguration('DAVINCI_SETTINGS_WHISPER_FREE_TIER_WELCOME_MINUTES', request('set-free-minutes'));

        $this->storeConfiguration('AWS_ACCESS_KEY_ID', request('set-aws-access-key'));
        $this->storeConfiguration('AWS_SECRET_ACCESS_KEY', request('set-aws-secret-access-key'));
        $this->storeConfiguration('AWS_DEFAULT_REGION', request('set-aws-region'));
        $this->storeConfiguration('AWS_BUCKET', request('set-aws-bucket'));

        $this->storeConfiguration('WASABI_ACCESS_KEY_ID', request('set-wasabi-access-key'));
        $this->storeConfiguration('WASABI_SECRET_ACCESS_KEY', request('set-wasabi-secret-access-key'));
        $this->storeConfiguration('WASABI_DEFAULT_REGION', request('set-wasabi-region'));
        $this->storeConfiguration('WASABI_BUCKET', request('set-wasabi-bucket'));

        $this->storeConfiguration('AZURE_SUBSCRIPTION_KEY', request('set-azure-key'));
        $this->storeConfiguration('AZURE_DEFAULT_REGION', request('set-azure-region'));
        $this->storeConfiguration('GOOGLE_APPLICATION_CREDENTIALS', request('gcp-configuration-path'));

        # Enable/Disable GCP Voices
        if (request('enable-gcp') == 'on') {
            $gcp_nrl = Vendor::where('vendor_id', 'gcp_nrl')->first();
            $gcp_nrl->enabled = 1;
            $gcp_nrl->save();

        } else {
            $gcp_nrl = Vendor::where('vendor_id', 'gcp_nrl')->first();
            $gcp_nrl->enabled = 0;
            $gcp_nrl->save();
        }


        if (request('enable-gcp') == 'on') {
            DB::table('voices')->where('vendor_id', 'gcp_nrl')->update(array('status' => 'active'));
    
        } else {
            DB::table('voices')->where('vendor_id', 'gcp_nrl')->update(array('status' => 'deactive'));
        }


        # Enable/Disable Azure Voices
        if (request('enable-azure') == 'on') {
            $azure_nrl = Vendor::where('vendor_id', 'azure_nrl')->first();
            $azure_nrl->enabled = 1;
            $azure_nrl->save();

        } else {
            $azure_nrl = Vendor::where('vendor_id', 'azure_nrl')->first();
            $azure_nrl->enabled = 0;
            $azure_nrl->save();
        }


        if (request('enable-azure') == 'on') {
            DB::table('voices')->where('vendor_id', 'azure_nrl')->update(array('status' => 'active'));
    
        } else {
            DB::table('voices')->where('vendor_id', 'azure_nrl')->update(array('status' => 'deactive'));
        }

        toastr()->success(__('Settings were successfully updated'));
        return redirect()->back();       
    }


    /**
     * Record in .env file
     */
    private function storeConfiguration($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {

            file_put_contents($path, str_replace(
                $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
            ));

        }
    }
}
