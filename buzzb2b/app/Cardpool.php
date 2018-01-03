<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cardpool extends Model
{
	protected $table = 'cardpools';
    public  $fillable = ['number','type','available','exchange_id','download'];
    
    /*number of barter card you want to generate*/
    public static function Bartercards(){
    	$numbers = [50=>50,100=>100,500=>500,1000=>1000,2000=>2000];
    	return $numbers;
    }
}
