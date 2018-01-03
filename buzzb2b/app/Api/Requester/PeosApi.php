<?php namespace App\Api\Requester;

use GuzzleHttp\Client as GuzzleClient;
use Config;

class PeosApi {
	
	/**
	 * @var GuzzleHttp\Client
	 */
	protected $client;

	/**
	 * @var string
	 */
	protected $request_method;

	/**
	 * @var string
	 */
	protected $request_uri;

	/**
	 * @var array
	 */
	protected $request_query_params;
	
	/**
	 * Instantiate a new client instance and capture the request method & uri
	 * 
	 * @param  string $request_method
	 * @param  string $request_uri
	 * 
	 * @return PeosApi
	 */
	public function request($request_method, $request_uri)
	{
		$this->client = new GuzzleClient(['base_url' => Config::get('peos.api_base_url')]);

		$this->request_method = $request_method;
		$this->request_uri = $request_uri;

		return $this;
	}
	
	/**
	 * Capture the response query parameters
	 * 
	 * @param  array  $request_query_params
	 * 
	 * @return PeosApi
	 */
	public function params(array $request_query_params)
	{
		$this->request_query_params = $request_query_params;

		return $this;
	}
	
	/**
	 * Perform an HTTP request and return json response
	 * 
	 * @return json
	 */
	public function get()
	{
		$request = $this->client->createRequest($this->request_method, $this->request_uri, $this->buildRequestArgs());

		$api_response = $this->client->send($request);

		$response = json_decode($api_response->getBody());

		if (isset($response->error))
		{
			switch ($response->error->status_code) {
				case 401:
					throw new PeosApiV2RequesterAuthenticationException($response->error->message);
					break;

				case 422:
					throw new PeosApiV2RequesterValidationException($response->error->message);
					break;
				
				default:
					throw new PeosApiV2RequesterException($response->error->message);
					break;
			}
		}

		return $response;
	}

	/**
	 * Builds request argument array for guzzle request, adds a jwt-token if requested from an authenticated user
	 * 
	 * @return array
	 */
	private function buildRequestArgs()
	{
		$request_args = $this->getDefaultRequestArgs();

		if ($this->request_query_params)
		{
			$request_args['query'] = $this->request_query_params;
		}

		$token = $this->getUserJwtToken();

		if ($token)
		{
			$request_args['query'] = (array_key_exists('query', $request_args)) ? array_add($request_args['query'], 'token', $token) : ['token' => $token];
		}

		return $request_args;
	}

	/**
	 * Gets the default request argument array for all guzzle requests
	 * 
	 * @return array
	 */
	private function getDefaultRequestArgs()
	{
		return [
			'exceptions' => false
		];	
	}

	/**
	 * Gets a JWT token from currently logged in requesting user (if any)
	 * 
	 * @return string
	 */
	private function getUserJwtToken()
	{
		$user = \Auth::user();

		if ( ! $user)
			return false;

		$token = \JWTAuth::fromUser($user);

		return $token;
	}

}