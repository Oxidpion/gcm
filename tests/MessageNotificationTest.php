<?php

namespace test;

use oxidpion\gcm\MessageNotification;


class MessageNotificationTest extends \PHPUnit_Framework_TestCase
{
	
	private $notification;
	
	public function setUp()
	{
		$this->notification = new MessageNotification();
	}
	
	public function testDefaultValue()
	{
		$this->assertNull($this->notification->title);
		$this->assertNull($this->notification->body);
		$this->assertNull($this->notification->icon);
		$this->assertNull($this->notification->sound);
		$this->assertNull($this->notification->badge);
		$this->assertNull($this->notification->tag);
		$this->assertNull($this->notification->color);
		$this->assertNull($this->notification->clickAction);
		$this->assertNull($this->notification->bodyLocKey);
		$this->assertNull($this->notification->bodyLocArgs);
		$this->assertNull($this->notification->titleLocKey);
		$this->assertNull($this->notification->titleLocArgs);
	}
	
	/**
	 * @expectedException oxidpion\gcm\Exception
	 * @expectedExceptionCode 2
	 */
	public function testGetWrongProperty()
	{
		$this->notification->wrong_property;
	}
	
	/**
	 * @expectedException oxidpion\gcm\Exception
	 * @expectedExceptionCode 2
	 */
	public function testSetWrongProperty()
	{
		$this->notification->wrong_property = 1;
	}
	
	/**
	 * @dataProvider providerReadWriteProperty
	 */
	public function testReadWriteProperty($name, $value)
	{
		$this->notification->$name = $value;
		$this->assertEquals($value, $this->notification->$name);
	}
		
	public function providerReadWriteProperty()
	{
		return array(
				array('title', 'Test'),
				array('body', 'Test'),
				array('icon', 'Test'),
				array('sound', 'Test'),
				array('badge', 'Test'),
				array('tag', 'Test'),
				array('color', 'Test'),
				array('clickAction', 'Test'),
				array('bodyLocKey', 'Test'),
				array('bodyLocArgs', array()),
				array('titleLocKey', 'Test'),
				array('titleLocArgs', array()),
		);
	}
	
	public function testAsArrayIsEmpty() 
	{
		$this->assertEmpty($this->notification->asArray());
	}
	
	public function testAsArrayIsOneProperty()
	{
		$this->notification->title = 'Test';
		$this->assertCount(1, $this->notification->asArray());
	}
}