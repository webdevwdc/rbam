<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function member_tag()
    {
        return $this->hasMany('App\MemberTag','tag_id');
    }
}
