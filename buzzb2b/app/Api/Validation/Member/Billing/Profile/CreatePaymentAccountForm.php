<?php namespace Api\Api\Validation\Member\Billing\Profile;

use Laracasts\Validation\FormValidator;

class CreatePaymentAccountForm extends FormValidator {

	/**
	 * Validation rules for creating a vault payment account
	 * 
	 * @var array
	 */
	protected $rules = [
		'payment_type' => 'required',
		'first_name' => 'required',
		'last_name' => 'required',
		'address1' => 'required_if:address_id,0',
		'address2' => 'different:address1',
		'city' => 'required_if:address_id,0',
		'state_id' => 'required_if:address_id,0',
		'zip' => 'required_if:address_id,0|numeric',
		'cc_number' => 'required_if:payment_type,CREDIT_CARD|luhn',
		'cc_cvv' => 'required_if:payment_type,CREDIT_CARD|numeric',
		'cc_exp_month' => 'required_if:payment_type,CREDIT_CARD',
		'cc_exp_year' => 'required_if:payment_type,CREDIT_CARD',
		'check_routing_number' => 'required_if:payment_type,CHECK',
		'check_account_number' => 'required_if:payment_type,CHECK',
		'check_number' => 'required_if:payment_type,CHECK',
	];

	public $messages = [
		'payment_type.required' => 'Please specify a payment type',
		'first_name.required' => 'Please enter a valid First Name',
		'last_name.required' => 'Please enter a valid Last Name',
		'address1.required_if' => 'Please enter a Street Address',
		'address2.different' => 'The Suite/Unit must be different than the street address',
		'city.required_if' => 'Please enter a City',
		'state_id.required_if' => 'Please select a State',
		'zip.required_if' => 'Please enter a Zip/Postal code',
		'zip.numeric' => 'The Zip/Postal code must be a numeric value',
		'cc_number.required_if' => 'Please enter a Credit Card Number',
		'cc_number.luhn' => 'Please enter a valid Credit Card Number',
		'cc_cvv.required_if' => 'Please enter a CVV Code',
		'cc_cvv.numeric' => 'Please enter a valid CVV Code',
		'cc_exp_month.required' => 'Please enter a Credit Card expiration month',
		'cc_exp_year.required' => 'Please enter a Credit Card expiration year',
		'check_routing_number.required_id' => 'Please enter a Routing Number',
		'check_account_number.required_id' => 'Please enter a Checking Account Number',
		'check_number.required_id' => 'Please enter a Check Number',
	];

}