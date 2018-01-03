<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class PaymentAddress extends Model
{
    protected $table = 'payment_address';
    //public    $fillable = ['addressable_id','addressable_type','address1','address2','city','state_id','zip','is_default'];	
    

    public function state(){
        return $this->belongsTo('App\State','state_id');
    } 
}
