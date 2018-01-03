<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberCashier extends Model
{   
	//use SoftDeletes;
    protected $table = 'member_cashiers';
    public $fillable = ['member_id','user_id','nickname'];
    
    
       
}
