<?php namespace Api\Api\Validation\User;

use Laracasts\Validation\FormValidator;

class LoginForm extends FormValidator {

	/**
	 * Validation rules for authenticating a user
	 * 
	 * @var array
	 */
	protected $rules = [
		'email' => 'required|email',
		'password' => 'required'
	];

}