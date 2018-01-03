<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bartercard extends Model
{   
	use SoftDeletes;

	protected $table = 'bartercards';
    public  $fillable = ['exchange_id','member_id','user_id','number','active',];

    public function member()
    {
    	return $this->belongsTo('App\Member');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function exchange()
    {
    	return $this->belongsTo('App\Exchange');
    }
    
}
