<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashReferral extends Model
{
	protected $table = 'cash_refarrals';
	public  $fillable = ['ravable_id', 'ravable_type', 'exchange_id', 'referring_user_id', 'referral_type', 'email', 'phone', 'personal_message', 'created_at', 'updated_at', 'fullname', 'informed'];
	
	public function member(){
		return $this->belongsTo('App\Member','ravable_id');
	}
	
	public function user(){
		return $this->belongsTo('App\User','referring_user_id');
	}
}
