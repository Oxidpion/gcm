<?php

namespace oxidpion\gcm;


/**
 * Downstream HTTP messages (JSON)
 * For more information about downstream messaging, 
 * see https://developers.google.com/cloud-messaging/http-server-ref
 * @author universal
 *
 */
class Message
{
	
	/**
	 * This parameter specifies the recipient of a message.
	 * The value must be a registration token or notification key.
	 * @var string Required
	 */
	private $to; 
	
	/**
	 * This parameter specifies a list of devices (registration tokens, or IDs)
	 *  receiving a multicast message. It must contain at least 1 and at most 1000 registration IDs.
	 * @var array
	 */
	private $registration_ids;
	
	/**
	 * Note that there is no guarantee of the order in which messages get sent.
	 * @var string Optional
	 */
	private $collapse_key;
	
	/**
	 * Sets the priority of the message. Valid values are "normal" and "high".
	 * On iOS, these correspond to APNs priority 5 and 10.
	 * @var string Optional
	 */
	private $priority;
	
	/**
	 * On iOS, use this field to represent content-available in the APNS payload.
	 * When a notification or message is sent and this is set to true,
	 * an inactive client app is awoken. On Android, data messages wake the app by default.
	 * On Chrome, currently not supported.
	 * @var boolean Optional
	 */
	private $content_available;
	
	/**
	 * When this parameter is set to true,
	 * it indicates that the message should not be sent until the device becomes active.
	 * The default value is false.
	 * @var boolean Optional
	 */
	private $delay_while_idle;
	
	/**
	 * This parameter specifies how long (in seconds) the message should be kept in GCM storage
	 * if the device is offline. The maximum time to live supported is 4 weeks.
	 * The default value is 4 weeks. 
	 * @var integer Optional
	 */
	private $time_to_live;
	
	/**
	 * This parameter specifies the package name of the application where the registration tokens
	 * must match in order to receive the message.
	 * @var string Optional
	 */
	private $restricted_package_name;
	
	/**
	 * This parameter, when set to true, allows developers to test a request without 
	 * actually sending a message. The default value is false.
	 * @var boolean Optional
	 */
	private $dry_run;
	
	/**
	 * This parameter specifies the custom key-value pairs of the message's payload.
	 * @var mixed Optional
	 */
	private $data;
	
	/**
	 * This parameter specifies the predefined, user-visible key-value pairs of the notification payload.
	 * See Notification payload support for detail.
	 * @var MessageNotification
	 */
	private $notification;
	
	public function __construct()
	{
		$this->notification = new MessageNotification();
	}
	
	public function setTo($value)
	{
		$this->to = (string) $value;
		return $this;
	}
	
	public function getTo()
	{
		return $this->to;		
	}
	
	public function setRegistrationIds(array $value)
	{
		$this->registration_ids = $value;
		return $this;
	}
	
	public function getRegistrationIds()
	{
		return $this->registration_ids;
	}
	
	public function setCollapseKey($value)
	{
		$this->collapse_key = (string) $value;
		return $this;
	}
	
	/**
	 * only normal or high
	 * @param string $value
	 */
	public function setPriority($value)
	{
		if ($value === 'normal' || $value === 'high') {
			$this->priority = $value;
			return $this;
		} else {
			throw new Exception('Only normal or high', Exception::ERROR_PROPERTY);
		} 
	}
	
	public function setContentAvailable($value)
	{
		if(is_bool($value)) {
			$this->content_available = $value;
			return $this;
		} else {
			throw new Exception('Only boolean', Exception::ERROR_PROPERTY);
		}
	}
	
	public function setDelayWhileIdle($value)
	{
		if (is_bool($value)) {
			$this->delay_while_idle = $value;
			return $this;
		} else {
			throw new Exception('Only boolean', Exception::ERROR_PROPERTY);
		}
		
	}
	
	public function setTimeToLive($value)
	{
		if ($value < 2419201) {
			$this->time_to_live = (int) $value;
			return $this;
		} else {
			throw new Exception('Too long time to live', Exception::ERROR_PROPERTY);
		}
	}
	
	public function setRestrictedPackageName($value)
	{
		$this->restricted_package_name = (string) $value;
		return $this;
	}
	
	public function setDryRun($value)
	{
		if (is_bool($value)) {
			$this->dry_run = $value;
			return $this;
		} else {
			throw new Exception('Dry Run only boolean', Exception::ERROR_PROPERTY);
		}	
	}
	
	public function setData($value)
	{
		$this->data = $value;
		return $this;
	}
	
	public function getData()
	{
		return $this->data;
	}
	
	public function setNotification(MessageNotification $value)
	{
		$this->notification = $value;
		return $this;
	}
	
	public function getNotification()
	{
		return $this->notification;
	}
	
	public function asArray()
	{
		$array = array();
		foreach ($this as $name => $value) {
			if (!is_null($value)) {
				$array[$name] = $value;
			}
		}
		$arr = $this->notification->asArray();
		if(!empty($arr)) {
			$array['notification'] = $arr;
		} else {
			unset($array['notification']);
		}
		return $array;
	}
	
	/**
	 * json
	 */
	public function __toString()
	{
		$arr = $this->asArray();
		return json_encode($arr);
	}
}