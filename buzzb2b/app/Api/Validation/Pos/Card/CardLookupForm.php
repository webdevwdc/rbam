<?php namespace Api\Api\Validation\Pos\Card;

use Laracasts\Validation\FormValidator;

class CardLookupForm extends FormValidator {

	/**
	 * Validation rules for a member looking up a card number
	 * 
	 * @var array
	 */
	protected $rules = [
		'card_number' => 'required',
	];

}