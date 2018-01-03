<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Address extends Model
{
    protected $table = 'addresses';
    public    $fillable = ['addressable_id','addressable_type','address1','address2','city','state_id','zip','is_default'];	
    
    public function state()
    {
        return $this->hasOne('App\State', 'id','state_id');
    }
    
    public function map_state_address(){
        return $this->belongsTo('App\State','state_id');
    }
    
//    public function members(){
//	return $this->belongsTo('App\Member', 'id', 'addressable_id');
//    }
//    
//    public function users(){
//	return $this->belongsTo('App\User', 'id', 'addressable_id');
//    }

    public function defaultAddress()
    {
	return $this->addresses()->where('is_default', true)->first();
    }
    
    public static function AddAddress($input,$type){
    	Self::create([
         'address1'=>$input['address1'],
         'addressable_id'=>Auth::user()->id,
         'addressable_type'=>$type,
         'address2'=>$input['address2'],
         'city'=>$input['city'],
         'state_id'=>$input['state'],
         'zip'=>$input['zip'],
         'is_default'=>$input['is_default'],
        ]); 
    }

    public static function DeleteAddress($id){
    	Self::where('id',$id)->delete();
    }
    
}
