<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Zorb\Promocodes\Traits\AppliesPromocode;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable; 
    use HasRoles; 
    use AppliesPromocode;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'job_role',
        'company',
        'website',
        'email',
        'workbook',
        'password',
        'phone_number',
        'address',
        'city',
        'postal_code',
        'plan_type',
        'country',
        'profile_photo_path',
        'oauth_id',
        'oauth_type',
        'last_seen',
        'referral_id',
        'referred_by',
        'referral_payment_method',
        'referral_paypal',
        'referral_bank_requisites',
        'default_voiceover_language',
        'default_voiceover_voice'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'available_words',
        'available_words_prepaid',
        'total_words',
        'available_images',
        'available_images_prepaid',
        'total_images',
        'group',
        'plan_id',
        'status',
        'balance',
        'google2fa_enabled',
        'google2fa_secret',
        'available_chars',
        'available_chars_prepaid',
        'available_minutes',
        'available_minutes_prepaid',
        'total_chars',
        'total_minutes'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function path()
    {
        return route('admin.users.show', $this);
    }

    /**
     * User can have many support tickets
     */
    public function support()
    {
        return $this->hasMany(SupportTicket::class);
    }

    /**
     * User can have many payments
     */
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    public function subscriber()
    {
        return $this->hasOne(Subscriber::class);
    }


    public function hasActiveSubscription()
    {
        return optional($this->subscriber)->isActive($this->id) ?? false;
    }
    public function afl()
    {
        // $cek = $this->afl_id;
        $cek = $this->referred_by;
        if($cek){
            $user = User::find($this->referred_by);
            $cek_afl = $user->afl_id;
            if($cek_afl == 0 || $cek_afl == null){
                return AfilieteDistibutes::where('as_default',1)->first();
            }else{
                return AfilieteDistibutes::find($cek_afl);
            }
        }else{
            return AfilieteDistibutes::where('as_default',1)->first();
        }
        // if($cek == 0 || $cek == null){
        //     return AfilieteDistibutes::where('as_default',1)->first();
        // }else{
        //     return AfilieteDistibutes::find($cek);
        // }
    }
    public function afl_mark(){
        $mark = $this->afl_mark;
        $cek_link = $this->afl_id;
        $afl = AfilieteDistibutes::find($cek_link);
        if( $mark != 0 && $afl){
           if($mark == 1){
            return $afl->manag;
           }elseif($mark == 2){
            return $afl->sub_manag;
           }else{
            return $afl->afl_user;
           }
        }else{
            $afl =  AfilieteDistibutes::where('as_default',1)->first();
            return $afl->afl_user;
        }
    }

}
