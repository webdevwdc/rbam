<?php namespace App\Api\Commands\User;

class AuthenticateUserCommand {

	public $validation_form;

	public $email;

	public $password;

	public function __construct($validation_form, $email, $password)
	{
		$this->validation_form = $validation_form;
		$this->email = $email;
		$this->password = $password;
	}

}