<?php namespace Api\Api\Validation\Pos\Member;

use Laracasts\Validation\FormValidator;

class CashierListForm extends FormValidator {

	/**
	 * Validation rules for a member retrieving a list of its cashiers
	 * 
	 * @var array
	 */
	protected $rules = [
		'merchant_member_slug' => 'required',
	];

}