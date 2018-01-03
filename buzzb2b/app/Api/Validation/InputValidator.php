<?php namespace App\Api\Validation;

use Laracasts\Commander\CommandBus;
use Illuminate\Foundation\Application;
use Laracasts\Validation\FormValidationException;
use Peos\Api\Validation\InputValidationException;

class InputValidator implements CommandBus {

	private $app;

	function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function execute($command)
	{
		// get validation form class name
		$form = $this->getValidationFormClass($command->validation_form);

		try
		{
			// perform validation
			$this->app->make($form)->validate( (array) $command);
		}
		catch (FormValidationException $e)
		{
			throw new InputValidationException($this->getErrorMessage($e));
		}
	}

	private function getValidationFormClass($validation_form)
	{
		$class = 'Peos\\Api\\Validation\\' . str_replace('.', '\\', $validation_form);

		if ( ! class_exists($class))
		{
			throw new \Exception('Class '.$class.' does not exist!');
		}

		return $class;
	}

	private function getErrorMessage($exception)
	{
		$errors = $exception->getErrors();

		if ($errors->count() == 1)
			return $errors->first();

		$errorMessage = '';

		foreach ($errors->all() as $error)
		{
			$errorMessage .= $error . ' ';
		}

		return $errorMessage;
	}

}