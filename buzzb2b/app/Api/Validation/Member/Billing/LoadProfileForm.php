<?php namespace Api\Api\Validation\Member\Billing;

use Laracasts\Validation\FormValidator;

class LoadProfileForm extends FormValidator {

	/**
	 * Validation rules for charging a payment account
	 * 
	 * @var array
	 */
	protected $rules = [
		'customer_member_slug' => 'required',
		'billing_profile_id' => 'required',
		'charge_amount' => 'required',
	];

	public $messages = [
		'customer_member_slug.required' => 'Please enter a Customer Member slug.',
		'billing_profile_id.required' => 'Please enter a Billing Profile id.',
		'charge_amount.required' => 'Please enter a Deposit Amount.',
	];

}