<?php

namespace oxidpion\gcm;

class Sender
{
	const SERVER_URL = 'https://gcm-http.googleapis.com/gcm/send';
	
	private $apiKey;
	
	private $resultHttpCode;
	
	public function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
	}
	
	public function send(Message $message)
	{
		if ($this->validateData($message)) {
			$response = $this->request((string) $message);
			switch ($this->resultHttpCode) {
				case '200':
					break;
				case '400': 
					throw new Exception('Malformed request. ' . $response, Exception::MALFORMED_REQUEST);
					break;
				case '401':
					throw new Exception('Authentication Error. '.$response, Exception::AUTHENTICATION_ERROR);
					break;
				default:
					throw new Exception('Unknown error. ' . $response, Exception::UNKNOWN_ERROR);
			}
			return $response;
		}
		return null;
	}
	
	private function validateData(Message $message) 
	{
		$notice = $message->getNotification();
		if (strlen($notice) > 2048) {
			throw new Exception('Notification payload is to big (max 2048)', Exception::MALFORMED_REQUEST);
			return false;
		}
		
		$data = $message->getData();
		if (strlen(json_encode($data)) > 4096) {
			throw new Exception('Data payload is to big (max 4096)', Exception::MALFORMED_REQUEST);
			return false;
		}
		return true;
	}
	
	private function request($rawdata) 
	{
		
		if (is_bool($this->apiKey) || empty($this->apiKey)) {
			throw new Exception('Error set Api Key', Exception::ILLEGAL_API_KEY);
		}
		$optionsUrl = array(
			CURLOPT_URL => self::SERVER_URL,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => array(
				'Authorization: key=' . $this->apiKey,
				'Content-Type: application/json',
			),
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $rawdata,
		);
		
		$curl = curl_init();
		curl_setopt_array($curl,$optionsUrl);
		$response = curl_exec($curl);
		
		$this->resultHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ($response === false) {
			throw new Exception('Curl request failed: ' . curl_error($curl) , curl_errno($curl));;
		}
		curl_close($curl);
		
		return $response;
	}
}