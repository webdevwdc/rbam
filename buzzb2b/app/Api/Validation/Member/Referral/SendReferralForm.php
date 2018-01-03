<?php namespace Api\Api\Validation\Member\Referral;

use Laracasts\Validation\FormValidator;

class SendReferralForm extends FormValidator {

	/**
	 * Validation rules for sending a member referral message
	 * 
	 * @var array
	 */
	protected $rules = [
		'member_slug' => 'required',
		'contact_email' => 'email',
		'contact_phone' => 'phone',
		'contact_fullname' => 'required',
	];

	public $messages = [
		'member_slug.required' => 'Please enter a Referring Member slug.',
		'contact_email.email' => 'Please enter a valid email address to contact.',
		'contact_phone.phone' => 'Please enter a valid phone number to contact.',
		'contact_fullname.required' => 'Please enter the name of recipient.',
	];

}