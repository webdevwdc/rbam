<?php namespace App\Api\Filters;

class JwtAuthFilter {

	public function filter($route, $response)
	{
		\JWTAuth::parseToken()->authenticate();
	}
}