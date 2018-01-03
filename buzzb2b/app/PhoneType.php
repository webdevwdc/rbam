<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneType extends Model
{   
    protected $table = 'phone_types';
    public    $fillable = ['name','status'];

    public function phone()
    {
        return $this->hasMany('App\Phone','phone_type_id');
    }
}
