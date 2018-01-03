<?php namespace Api\Api\Validation\Member\Billing\Profile;

use Laracasts\Validation\FormValidator;

class GetPaymentAccountsByMemberForm extends FormValidator {

	/**
	 * Validation rules for creating a vault payment account
	 * 
	 * @var array
	 */
	protected $rules = [
		'member_slug' => 'required',
	];

	public $messages = [
		'member_slug.required' => 'Please enter a member slug',
	];

}