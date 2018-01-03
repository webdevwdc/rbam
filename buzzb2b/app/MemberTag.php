<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberTag extends Model
{
    protected $table = 'member_tags';
    public    $fillable = ['member_id','tag_id'];	
    
    
    public function tags()
    {
        return $this->belongsTo('App\Tag', 'tag_id');
    }
    
    public function members(){
        return $this->belongsTo('App\Member', 'member_id');
    }
}
