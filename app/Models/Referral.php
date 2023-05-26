<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'referrer_id',
        'referred_id',
        'referrer_email',
        'referred_email',
        'storage',
        'order_id',
        'payment',
        'commission',
        'rate',
        'status',
        'gateway',
        'purchase_date',
    ];

    public static function distibuteBonus($id){
        $user = User::find($id->user_id);
        if($user->referred_by != null){
            $refer = User::find($user->referred_by);
        }else{
            $refer = false;
        }
        
        if($refer){
            $refNext2   = User::find($refer->referred_by);
        }else{
            $refNext2   = false;
        }

        if ($refNext2) {
            $refNext3  = User::find($refNext2->referred_by); 
        }else{
            $refNext3  = false;
        }
        

        $afl = $user->afl();        
        if($afl->afl_user != 0){
            if ($refer) {
                 Referral::create([
                    'referrer_id'       => $refer->id,
                    'referrer_email'    => $refer->email,
                    'referred_id'       => $user->id,
                    'referred_email'    => $user->email,
                    'rate'              => $afl->afl_user,
                    'order_id'          => $id->order_id,
                    'payment'           => $id->price,
                    'commission'        => $id->price * $afl->afl_user/100,
                    'status'            => $id->status,
                    'gateway'           => $id->gateway,
                    'purchase_date'     => now(), 
                ]);
            } 
        }
        if($afl->sub_manag != 0){
            if ($refNext2) {
                Referral::create([
                    'referrer_id'       => $refNext2->id,
                    'referrer_email'    => $refNext2->email,
                    'referred_id'       => $refer->id,
                    'referred_email'    => $refer->email,
                    'rate'              => $afl->sub_manag,
                    'order_id'          => $id->order_id,
                    'payment'           => $id->price,
                    'commission'        => $id->price * $afl->sub_manag/100,
                    'status'            => $id->status,
                    'gateway'           => $id->gateway,
                    'purchase_date'     => now(), 
                ]); 
            }
        }
        if($afl->manag != 0){
            if ($refNext3) {
                Referral::create([
                    'referrer_id'       => $refNext3->id,
                    'referrer_email'    => $refNext3->email,
                    'referred_id'       => $refNext2->id,
                    'referred_email'    => $refNext2->email,
                    'rate'              => $afl->manag,
                    'order_id'          => $id->order_id,
                    'payment'           => $id->price,
                    'commission'        => $id->price * $afl->manag/100,
                    'status'            => $id->status,
                    'gateway'           => $id->gateway,
                    'purchase_date'     => now(), 
                ]); 
            }
        }
        return true;
        
    }

}
