<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType;
use Hash;
use App\Helpers;
use App\Transformers\UserMemberDashboardTransformer;


class MemberController extends ApiV2Controller
{
    
    
    protected $user;
    protected $id;

	public function __construct()
	{
		parent::__construct();

		$this->user = \JWTAuth::parseToken()->authenticate();
                $this->id = $this->user->id;
                
	}
    
    
    /**
	 * @api {get} /member/dashboard/selected  Get dashboard data for the user's selected member
	 * @apiName GetForDashboard
	 * @apiGroup Member
	 *
	 * @apiSuccess {Object} Member
	 */
	public function getForDashboard()
	{
		$selectedMember = $this->user->members()->first();
                if ( ! $selectedMember)
		{
			return $this->respondNotFound('A selected member could not be found for this user.');
		}

		return $this->respond($this->makeItem($this->user, new UserMemberDashboardTransformer));
	}
    
    public function changeSelectedMember(Request $request){
       
         extract($request->all());
         $requestedMember = Member::where('slug', $member_slug)->first();
         if(count($requestedMember)==0){

           return response()->json( array('error'=>array('message' => 'The member requested could not be found.','status_code'=>401)));                
                 
         }
         $member = new Member();
        if ( ! $member->setSelectedMember($requestedMember->id,$this->id)) {
             
         }
         
         return $this->respond($this->makeItem($requestedMember, new MemberTransformer));
        // \DB::table('member_user')->where('user_id', $this->id)->update(['selected' => false]);
         // mark select requested member in db
        //\DB::table('member_user')->where('user_id', $this->id)->where('member_id', $member_id)->update(['selected' => true]);
         
    }
    
    
}
