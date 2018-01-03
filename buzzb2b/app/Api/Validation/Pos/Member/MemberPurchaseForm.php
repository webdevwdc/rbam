<?php namespace Api\Api\Validation\Pos\Member;

use Laracasts\Validation\FormValidator;

class MemberPurchaseForm extends FormValidator {

	/**
	 * Validation rules for a member posting a sale to a card
	 * 
	 * @var array
	 */
	protected $rules = [
		'customer_member_slug' => 'required',
		'merchant_member_slug' => 'required',
		'barter_amount' => 'required',
	];

}