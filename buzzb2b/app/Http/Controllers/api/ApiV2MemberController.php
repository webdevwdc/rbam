<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType;
use Hash;
use App\Helpers;
use App\Transformers\UserMemberDashboardTransformer;

class ApiV2MemberController extends ApiV2Controller {

	/*
	 * @var MemberRepo
	 */
	protected $memberRepo;

	/*
	 * @var User
	 */
	protected $user;
	protected $model;

	public function __construct()
	{
		parent::__construct();

		$this->user = \JWTAuth::parseToken()->authenticate();
                $this->id = $this->user->id;
				$this->model='LedgerDetails';
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
		$selectedMember = $this->user->selectedMember();
		
		if ( ! $selectedMember)
		{
			return $this->respondNotFound('A selected member could not be found for this user.');
		}

		return $this->respond($this->makeItem($this->user, new UserMemberDashboardTransformer));
	}
	
	
	
}
