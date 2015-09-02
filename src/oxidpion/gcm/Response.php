<?php

namespace oxidpion\gcm;

class Response
{
	/**
	 * It is necessary to update information on the device
	 * @var array
	 */
	private $update = array();
	
	/**
	 * From the device deleted application. It is necessary to delete information from a DB.
	 * @var array
	 */
	private $remove = array();
	
	
	/**
	 * Unavailable devices
	 * @var array
	 */
	private $unavailable = array();
	
	
	public function __construct(Message $message, $responseBody)
	{
		$response = json_decode($responseBody, true);
		if($response === null) {
			throw new Exception("Malformed reponse body. " . $responseBody, Exception::MALFORMED_RESPONSE);
		}
		$results = array();
		foreach ($message->getRegistrationIds() as $key => $registrationId) {
			$results[$registrationId] = $response['results'][$key];
		}
		
		if ($response['failure'] > 0) {
			$this->remove = $this->filterRemove($results);
			$this->unavailable = $this->filterUnavailable($results);
		}
		
		if($response['canonical_ids'] > 0) {
			$this->update = $this->filterUpdate($results);
		}
		
	}
	
	private function filterRemove($arr)
	{
		$filteredResults = array_filter($arr,
			function($result) {
				return (
					isset($result['error']) && 
					(
						($result['error'] == "NotRegistered") ||
						($result['error'] == "InvalidRegistration")
					)
				);
			}
		);
		return array_keys($filteredResults);
	} 
	
	private function filterUnavailable($arr)
	{
		$filteredResults = array_filter($arr,
			function($result) {
				return (isset($result['error'])	&& ($result['error'] == "Unavailable"));
			}
		);
		return array_keys($filteredResults);
	}
	
	private function filterUpdate($arr)
	{
		$filteredResults = array_filter($arr,
			function($result) {
				return isset($result['registration_id']);
			}
		);
		$data = array_map(
			function($result) {
				return $result['registration_id'];
			},
			$filteredResults
		);
		return $data;
	}
	
	public function getUpdate()
	{
		return $this->update;
	}
	
	public function getRemove()
	{
		return $this->remove;
	}
	
	public function getUnavailable()
	{
		return $this->unavailable;
	}
}