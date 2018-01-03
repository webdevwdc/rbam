<?php namespace Api\Api\Validation\Member\Billing;

use Laracasts\Validation\FormValidator;

class LoadNewForm extends FormValidator {

	/**
	 * Validation rules for charging and storing a payment account
	 * 
	 * @var array
	 */
	protected $rules = [
		'customer_member_slug' => 'required',
		'charge_amount' => 'required',
		'cc_number' => 'required_if:payment_type,CREDIT_CARD|luhn',
		'cc_cvv' => 'required_if:payment_type,CREDIT_CARD|numeric',
		'check_routing_number' => 'required_if:payment_type,CHECK',
		'check_account_number' => 'required_if:payment_type,CHECK',
		'check_number' => 'required_if:payment_type,CHECK',
		'first_name' => 'required',
		'last_name' => 'required',
		'address1' => 'required_if:address_id,0',
		'address2' => 'different:address1',
		'city' => 'required_if:address_id,0',
		'state_id' => 'required_if:address_id,0',
		'zip' => 'required_if:address_id,0|numeric',
	];

	public $messages = [
		'customer_member_slug.required' => 'Please enter a Customer Member slug.',
		'charge_amount.required' => 'Please enter a Deposit Amount.',
		'cc_number.required_if' => 'Please enter a Credit Card Number.',
		'cc_number.luhn' => 'Please enter a valid Credit Card Number.',
		'cc_cvv.required_if' => 'Please enter a CVV Code.',
		'cc_cvv.numeric' => 'Please enter a valid CVV Code.',
		'check_routing_number.required_id' => 'Please enter a Routing Number.',
		'check_account_number.required_id' => 'Please enter a Checking Account Number.',
		'check_number.required_id' => 'Please enter a Check Number.',
		'first_name.required' => 'Please enter a valid First Name.',
		'last_name.required' => 'Please enter a valid Last Name.',
		'address1.required_if' => 'Please enter a Street Address.',
		'address2.different' => 'The Suite/Unit must be different than the street address.',
		'city.required_if' => 'Please enter a City.',
		'state_id.required_if' => 'Please select a State.',
		'zip.required_if' => 'Please enter a Zip/Postal code.',
		'zip.numeric' => 'The Zip/Postal code must be a numeric value.',
	];

}