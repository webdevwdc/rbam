<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{	
	protected $table = 'phones';
	public    $fillable = ['phoneable_id','phoneable_type','phone_type_id','number','is_primary'];	

	
	public function members()
	{
	    return $this->morphMany('App\Member', 'members');
	}
	public function phoneType()
	{
	    return $this->belongsTo('App\PhoneType','phone_type_id','id');
	}
}
