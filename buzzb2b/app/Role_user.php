<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_user extends Model
{   

    protected $table ="role_user";
    public $primaryKey  = 'user_id';
    public $timestamps = false;
    public $fillable = ['user_id','role_id'];
    
    public function admin(){
       return $this->belongsTo('App\User','user_id','id');
    }
    
    public function RoleType(){
        return $this->belongsTo('App\Role','role_id');
    }
}
