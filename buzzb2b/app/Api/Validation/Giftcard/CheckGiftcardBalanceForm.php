<?php namespace Api\Api\Validation\Giftcard;

use Laracasts\Validation\FormValidator;

class CheckGiftcardBalanceForm extends FormValidator {

	/**
	 * Validation rules for checking a giftcard balance
	 * 
	 * @var array
	 */
	protected $rules = [
		'card_number' => 'required', 
	];

}