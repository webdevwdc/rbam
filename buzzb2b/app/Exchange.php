<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Exchange extends Model
{
    

    public $table = 'exchanges';
    public  $fillable = ['domain','name','city_name','member_purchase_comm_rate','member_ref_purchase_comm_rate','ex_default_use_giftcards'];

    public function relatedExchanges()
    {
	//return $this->belongsToMany('App\ExchangeRelationship', 'exchange_id');
	return $this->belongsToMany('App\Exchange', 'exchange_relationships', 'exchange_id', 'partner_exchange_id')->orderBy('name', 'asc')->withPivot('accept_barter_from', 'accept_giftcard_from', 'locked');
    }
    
    public function member(){
        return $this->hasOne('App\Member', 'exchange_id');
    }
   
    /*getting all exchanges*/
    public static function GetExchange(){
        [Session::put('exchanges',1)];
    	$exchange_name = Exchange::get();
    	return $exchange_name;$session;
    }
}
