<?php namespace App\Api\Requester\Facades;

use Illuminate\Support\Facades\Facade;

class PeosApi extends Facade {
	
	/**
	 * Name of IoC binding is...
	 *
	 * @return string
	 */
	public static function getFacadeAccessor()
	{
		return 'peosapi';
	}

}