<?php

use Peos\Repositories\Members\MemberRepo;
use Peos\Api\Transformers\MemberTransformer;

use Peos\Api\Validation\User\ChangeSelectedMemberForm;


class ApiV2UserController extends \ApiV2Controller {

	/*
	 * @var MemberRepo
	 */
	protected $memberRepo;

	/*
	 * @var ChangeSelectedMemberForm
	 */
	protected $changeSelectedMemberForm;

	/*
	 * @var User
	 */
	protected $user;

	public function __construct(MemberRepo $memberRepo, ChangeSelectedMemberForm $changeSelectedMemberForm)
	{
		parent::__construct();

		$this->memberRepo = $memberRepo;
		$this->changeSelectedMemberForm = $changeSelectedMemberForm;

		$this->user = \JWTAuth::parseToken()->authenticate();
	}

	/**
	 * @api {post} /selected/member/change  Attempt to change the user's selected member
	 * @apiName ChangeSelectedMember
	 * @apiGroup User
	 *
	 * @apiParam {string}  requested_member_slug  (required)  the member slug in which the user is attempting to change to
	 *
	 * @apiSuccess {Object} response
	 */

	public function changeSelectedMember()
	{
		# validate input
		$this->changeSelectedMemberForm->validate(\Input::all());

		# get member
		$requestedMember = $this->memberRepo->getBySlug(\Input::get('requested_member_slug'));

		if ( ! $requestedMember)
		{
			return $this->respondNotFound('The member requested could not be found.');
		}

		if ( ! $this->user->belongsToMemberId($requestedMember->id))
			return $this->respondWithError('That user does not belong to the specified member.');

		if ( ! $this->user->setSelectedMember($requestedMember->id))
			return $this->respondGeneralExceptionWithMessage('An error occurred when attempting to change the user\'s selected member.');
		
		return $this->respond($this->makeItem($requestedMember, new MemberTransformer));
	}

}
