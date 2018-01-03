<?php
namespace App\Http\Controllers\api;

use Illuminate\Http\Response as IlluminateResponse;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use App\Http\Controllers\Controller;


class ApiV2Controller extends Controller {

	

	/**
	 * HTTP status code
	 * 
	 * @var int
	 */
	protected $statusCode = IlluminateResponse::HTTP_OK;

	protected $fractal;

	public function __construct()
	{
		$this->fractal = \App::make('League\Fractal\Manager');
	}

	public function getStatusCode()
	{
		return $this->statusCode;
	}

	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	public function makeCollection($data, $transformer)
	{
		$collection = new Collection($data, $transformer);

		return $this->fractal->createData($collection)->toArray();
	}

	public function makeItem($data, $transformer)
	{
		$item = new Item($data, $transformer);

		return $this->fractal->createData($item)->toArray();
	}

	public function respondWithData($data = array())
	{
		return $this->respond([
			'data' => $data
		]);
	}

	public function respond($data, $headers = [])
	{
		return \Response::json($data, $this->getStatusCode(), $headers);
	}

	public function respondNotFound($message = 'Not found!')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}

	public function respondValidationFailed($message = 'Validation failed!')
	{
		if (is_object($message))
		{
			$message = $this->getErrorMessage($message);			
		}

		return $this->setStatusCode(422)->respondWithError($message);
	}

	public function respondAuthenticationFailed($message = 'Authentication failed!')
	{
		return $this->setStatusCode(401)->respondWithError($message);
	}

	public function respondGeneralException($e)
	{
		return $this->setStatusCode(500)->respondWithError($e->getMessage());
	}

	public function respondGeneralExceptionWithMessage($message = 'General exception!')
	{
		if (is_object($message))
		{
			$message = $this->getErrorMessage($message);			
		}

		return $this->setStatusCode(500)->respondWithError($message);
	}

	private function respondWithError($message)
	{
		return $this->respond([
			'error' => [
				'message' => $message,
				'status_code' => $this->getStatusCode(),
			]
		]);
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