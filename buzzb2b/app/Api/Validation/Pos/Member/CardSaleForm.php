<?php namespace Api\Api\Validation\Pos\Member;

use Laracasts\Validation\FormValidator;

class CardSaleForm extends FormValidator {

	/**
	 * Validation rules for a member posting a sale to a card
	 * 
	 * @var array
	 */
	protected $rules = [
		'merchant_member_slug' => 'required',
		'card_number' => 'required',
		'barter_amount' => 'required',
	];

}