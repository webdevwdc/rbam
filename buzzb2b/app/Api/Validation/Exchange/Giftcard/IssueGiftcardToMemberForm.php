<?php namespace Api\Api\Validation\Exchange\Giftcard;

use Laracasts\Validation\FormValidator;

class IssueGiftcardToMemberForm extends FormValidator {

	/**
	 * Validation rules for an exchange issuing a giftcard to a member
	 * 
	 * @var array
	 */
	protected $rules = [
		'merchant_exchange_domain' => 'required', 
		'customer_member_slug' => 'required', 
		'card_number' => 'required', 
		'barter_amount' => 'required', 

	];

}