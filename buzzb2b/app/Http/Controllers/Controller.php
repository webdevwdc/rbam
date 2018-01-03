<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use  \Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function __construct(){
    
    	Validator::extend('phone', function($attribute, $value, $parameters)
	{
	    return preg_match("/^([0-9\s\-\+\(\)]*)$/", $value);
	});
        
    }
        
}
