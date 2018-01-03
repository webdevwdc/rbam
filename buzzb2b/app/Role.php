<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    //
    public function RoleUser(){
            return $this->hasMany('App\Role_user','role_id');
    }
}
