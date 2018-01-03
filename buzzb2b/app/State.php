<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //
    
    public function address()
    {
        return $this->belongsTo('App\Address', 'id');
    }
    
    public function map_state_address(){
        return $this->hasMany('App\Address','state_id');
    }


    public function AllCity(){
    	$state = State::orderBy('abbrev','ASC')->pluck('abbrev','id')->all();
    	return $state;
    }
}
