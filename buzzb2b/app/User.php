<?php

namespace App;

use App\Address, App\Phone, App\MemberUser, App\Role_user;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Zizaco\Entrust\Traits\EntrustUserTrait;

 
class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    
    protected $table = 'users';
    public $fillable = ['first_name','last_name','email','password','image', 'deleted_at','is_admin'];
    
    


    public function setPasswordAttribute($password){   
        $this->attributes['password'] = bcrypt($password);
    }
    
    public function roleuser(){
       return $this->hasOne('App\Role_user','user_id','id');
    }
    
    public function memberuser()
    {
        return $this->hasMany('App\MemberUser','user_id');
    }
    
    public function members(){
       return $this->belongsToMany('App\Member','member_users','user_id', 'member_id')->withPivot('primary','admin','can_access_billing','can_pos_sell','can_pos_purchase','monthly_trade_limit')->orWhere('member_users.user_id','<>','');

    }
    
    public function selectedMember()
    {
	   return $this->members()->whereSelected(true)->first();
    }

    public function bartercard(){
        return $this->hasOne('App\Bartercard','user_id','id');
    }      
    
    
    public static function delete_user($user_id)
    {
        /*** Update into User Table ***/
        
        $user                   = User::find($user_id);
        $user->deleted_at       = date('Y-m-d H:i:s');
        $user->save();
    }
    
    
    /**
	 * Determines whether user has permission for the requested role within the specified member
	 * 
	 * @param  Member  $member
	 * @param  string  $role  primary|admin|billing|cashier|seller|purchaser
	 * @return boolean
	 */
	public function hasMemberAccess(Member $member, $role = false)
	{
		if ( ! $role || ! $member)
			return false;
                
		$userMember = $this->members()->where('member_id', $member->id)->first();
                
                if (empty($userMember))
		{
			return false;
		}

		return $this->hasUserMemberAccess($userMember, $role);
	}
        
        
        /**
	 * Determines whether the user association contains the permission for the requested role
	 * 
	 * @param  object  $userMember  a UserMember pivot association
	 * @param  string  $role  primary|admin|billing|cashier|seller|purchaser
	 * @return boolean
	 */
	public function hasUserMemberAccess($userMember = false, $role = false)
	{      
		if ( ! $userMember || ! $role)
			return false;

		switch ($role)
		{
			case 'primary':
				$access = $userMember->pivot->primary;
				break;

			case 'admin':
				$access = ( $userMember->pivot->primary || $userMember->pivot->admin ) ? true : false;
				break;

			case 'billing':
				$access = ( $userMember->pivot->primary || $userMember->pivot->admin || $userMember->pivot->can_access_billing ) ? true : false;
				break;

			case 'cashier':
				$access = ( $userMember->pivot->primary || $userMember->pivot->admin || $userMember->pivot->can_pos_sell || $userMember->pivot->can_pos_purchase ) ? true : false;
				break;

			case 'seller':
				$access = ( $userMember->pivot->primary || $userMember->pivot->admin || $userMember->pivot->can_pos_sell ) ? true : false;
				break;

			case 'purchaser':
				$access = ( $userMember->pivot->primary || $userMember->pivot->admin || $userMember->pivot->can_pos_purchase ) ? true : false;
				break;
			
			default:
				$access = false;
				break;
		}

		return (bool) $access;
	}
	
	public function hasCurrentMemberAccess($role = false)
	{
		if ( ! $role)
			return false;

		$selectedMember = $this->selectedMember();

		if ( ! $selectedMember)
			return false;

		return $this->hasUserMemberAccess($selectedMember, $role);
	}
	
	public function belongsToMemberId($memberID)
	{
		return MemberUser::where('member_id', $memberID)->first(['user_id']);
	}

	public static function GetUsersCount($user_id){
        return MemberUser::where('user_id',$user_id)->count();
    }
}
