<?php namespace Api\Api\Validation\User;

use Laracasts\Validation\FormValidator;

class ChangeSelectedMemberForm extends FormValidator {

	/**
	 * Validation rules for a user changing their selected member
	 * 
	 * @var array
	 */
	protected $rules = [
		'requested_member_slug' => 'required'
	];

}