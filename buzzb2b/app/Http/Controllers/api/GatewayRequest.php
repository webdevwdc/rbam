<?php namespace App\Http\Controllers\api;

class GatewayRequest {

	protected $url;
	protected $gatewayId;
	protected $gatewayKey;
	protected $request;

	public function __construct($url = '', $gatewayId = '', $gatewayKey = '')
	{
		$this->url = $url;
		$this->gatewayId = $gatewayId;
		$this->gatewayKey = $gatewayKey;
		$this->request = false;
	}

	public function get($uri)
	{
		$this->initialize($uri);

		return $this->executeRequest();
	}

	public function post($uri, array $data)
	{
		$this->initialize($uri);
                $postFields = json_encode($data);
		
		curl_setopt($this->request, CURLOPT_POST, 1);
		curl_setopt($this->request, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, "POST");

		return $this->executeRequest($postFields);
	}

	public function put($uri, array $data)
	{
		$this->initialize($uri);

		$postFields = json_encode($data);
		
		curl_setopt($this->request, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, "PUT");

		return $this->executeRequest($postFields);
	}

	public function delete($uri, array $data)
	{
		$this->initialize($uri);

		$postFields = json_encode($data);
		
		curl_setopt($this->request, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, "DELETE");

		return $this->executeRequest($postFields);
	}

	private function initialize($uri)
	{
		$this->request = curl_init($this->url . $uri);
	}

	private function executeRequest($postFields = '')
	{
		curl_setopt($this->request, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($this->request, CURLOPT_HTTPHEADER, [
			
			$this->getAuthorizationString(),

			'Content-Type: application/json',

			'Content-Length: ' . strlen($postFields)

		]);

		$response = curl_exec($this->request);

		// dd(json_decode($response));

		curl_close($this->request);

		return json_decode($response);
	}

	private function getAuthorizationString()
	{
		// 'Authorization: Basic ' . base64_encode('8003652:XLGL3G5IkZGp'),
		
		return 'Authorization: Basic ' . base64_encode( $this->gatewayId . ':' . $this->gatewayKey);
	}

}