<?php namespace Api\Api\Validation\Pos\Member;

use Laracasts\Validation\FormValidator;

class MerchantsListForm extends FormValidator {

	/**
	 * Validation rules for a member retrieving a merchant members list
	 * 
	 * @var array
	 */
	protected $rules = [
		'customer_member_slug' => 'required',
	];

}