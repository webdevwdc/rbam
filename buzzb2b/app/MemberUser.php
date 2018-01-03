<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class MemberUser extends Model
{	
	protected $table = 'member_users';
    public    $fillable = ['member_id','user_id','admin','primary','selected','monthly_trade_limit','can_pos_sell'];	


    public function member()
    {
        return $this->belongsTo('App\Member','member_id');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    
    
    /*getting all member*/
    public static function GetMember($id){
        $member = MemberUser::where('member_id',$id)->first();
        $user = User::where('id',$member->user_id)->first();
        return $user;
    }

    public static function getAssignBarterCard($id){
        return $numbers = Bartercard::where('user_id',$id)->first();
        return $numbers;
    }

    
}
