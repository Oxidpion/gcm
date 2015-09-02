<?php

namespace oxidpion\gcm;

class GCM
{
	protected $message;
	
	private $apiKey;
	
	public function newMessage()
	{
		$this->message = new Message();
		return $this->message;
	}
	
	public function send()
	{
		$sender = new Sender($this->apiKey);
		$response = $sender->send($this->message);
		
		foreach ($response->getUpdate() as $oldId => $newId) {
			$this->updateRegistrationIds($oldId, $newId);
		}
		
		foreach ($response->getRemove() as $id) {
			$this->removeInvalidRegistrationId($id);
		}
		
		foreach ($response->getUnavailable() as $id) {
			$this->unavailableRegistration($id);
		}
	}
	
	public function getApiKey()
	{
		return $this->apiKey;
	}
	
	public function setApiKey($value)
	{
		if (is_bool($value) || empty($value)) {
			throw new Exception('Error set Api Key', Exception::ILLEGAL_API_KEY);
		}
		$this->apiKey = $value;
		return $this;
	}
	
	public function updateRegistrationIds($oldId, $newId) { }
	
	public function removeInvalidRegistrationId($id) { }
	
	public function unavailableRegistration($id) { }
}