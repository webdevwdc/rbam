<?php namespace Api\Api\Validation\Directory;

use Laracasts\Validation\FormValidator;

class ExchangeForm extends FormValidator {

	/**
	 * Validation rules for an exchange directory search
	 * 
	 * @var array
	 */
	protected $rules = [
		'domain' => 'required',
		'category' => 'array'
	];

}