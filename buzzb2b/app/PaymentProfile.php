<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class PaymentProfile extends Model
{
    protected $table = 'payment_profiles';
    public    $fillable = ['member_user_id','member_user_type','address1','address2','city','state_id','zip','is_default'];	
    

    
    public function paymentAddress(){
        return $this->belongsToMany('App\PaymentAddress','payment_address_profiles','payment_profile_id','payment_address_id');
    }


    
}
