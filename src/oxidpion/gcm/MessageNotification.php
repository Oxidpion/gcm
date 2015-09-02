<?php

namespace oxidpion\gcm;

/**
 * Notification payload support
 * The following table lists the predefined parameters available to use in notification messages.
 * 
 * https://developers.google.com/cloud-messaging/http-server-ref
 * @author universal
 *
 * @property string $title
 * @property string $body
 * @property string $icon
 * @property string $sound
 * @property string $badge
 * @property string $tag
 * @property string $color
 * @property string $clickAction
 * @property string $bodyLocKey
 * @property array	$bodyLocArgs
 * @property string $titleLocKey
 * @property array	$titleLocArgs
 */
class MessageNotification
{
	/**
	 * Required (Android), Optional (iOS).
	 * Indicates notification title. This field is not visible on iOS phones and tablets.
	 * @var string
	 */
	private $title;
	
	/**
	 * Android, iOS.
	 * Indicates notification body text. 
	 * @var string
	 */
	private $body;
	
	/**
	 * Required (Android)
	 * Indicates notification icon.  
	 * @var string
	 */
	private $icon;
	
	/**
	 * Android, iOS.
	 * Indicates sound to be played. Supports only default currently.
	 * @var string
	 */
	private $sound;
	
	/**
	 * iOS
	 * Indicates the badge on client app home icon.
	 * @var string
	 */
	private $badge;
	
	/**
	 * Android
	 * Indicates whether each notification message results in a new entry 
	 * 	on the notification center on Android.
	 * If not set, each request creates a new notification.
	 * If set, and a notification with the same tag is already being shown,
	 * the new notification replaces the existing one in notification center.
	 * @var string
	 */
	private $tag;
	
	/**
	 * Android
	 * Indicates color of the icon, expressed in #rrggbb format
	 * @var string
	 */
	private $color;
	
	/**
	 * Android, iOS
	 * The action associated with a user click on the notification. 
	 * @var string
	 */
	private $click_action;
	
	/**
	 * Android, iOS
	 * Indicates the key to the body string for localization.
	 * @var string
	 */
	private $body_loc_key;
	
	/**
	 * Android, iOS
	 * Indicates the string value to replace format specifiers in body string for localization.
	 * @var array
	 */
	private $body_loc_args;
	
	/**
	 * Android, iOS
	 * Indicates the key to the title string for localization.
	 * @var string
	 */
	private $title_loc_key;
	
	/**
	 * Android, iOS
	 * Indicates the string value to replace format specifiers in title string for localization. 
	 * @var array
	 */
	private $title_loc_args;
	
	public function __get($name)
	{
		if (property_exists($this, $name)) {
			return $this->$name;
		}
		
		$getter = 'get' . ucfirst($name);
		if (method_exists($this, $getter)) {
			return $this->$getter();
		} else {
			throw new Exception('Getting unknown property: ' . $name, Exception::ERROR_PROPERTY);
		} 
	}
	
	public function __set($name, $value)
	{
		$setter = 'set' . ucfirst($name);  
		if (method_exists($this, $setter)) {
			return $this->$setter($value); 
		} else {
			throw new Exception('Getting unknown property: ' . $name, Exception::ERROR_PROPERTY);
		}
	}
	
	public function setTitle($value)
	{
		$this->title = (string) $value; 
		return $this;
	}
	
	public function setBody($value)
	{
		$this->body = (string) $value;
		return $this;
	}

	public function setIcon($value)
	{
		$this->icon = (string) $value;
		return $this;
	}
	
	public function setSound($value)
	{
		$this->sound = (string) $value;
		return $this;
	}
	
	public function setBadge($value)
	{
		$this->badge = $value;
		return $this;
	}
	
	public function setTag($value)
	{
		$this->tag = $value;
		return $this;
	}
	
	public function setColor($value)
	{
		$this->color = $value;
		return $this;
	}
	
	public function setClickAction($value)
	{
		$this->click_action = $value;
		return $this;
	}
	
	public function getClickAction()
	{
		return $this->click_action;
	}

	public function setBodyLocKey($value)
	{
		$this->body_loc_key = $value;
		return $this;
	}
	
	public function getBodyLocKey()
	{
		return $this->body_loc_key;
	}
	
	public function setBodyLocArgs(array $value)
	{
		$this->body_loc_args = $value;
		return $this;
	}
	
	public function getBodyLocArgs()
	{
		return $this->body_loc_args;
	}
	
	public function setTitleLocKey($value)
	{
		$this->title_loc_key = $value;
		return $this;
	}
	
	public function getTitleLocKey()
	{
		return $this->title_loc_key;
	}
	
	public function setTitleLocArgs(array $value)
	{
		$this->title_loc_args = $value;
		return $this;
	}
	
	public function getTitleLocArgs()
	{
		return $this->title_loc_args;
	}
	
	public function asArray()
	{
		$array = array();
		foreach ($this as $name => $value) {
			if (!is_null($value)) {
				$array[$name] = $value;
			} 
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