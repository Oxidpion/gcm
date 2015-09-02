<?php

namespace test;

use oxidpion\gcm\Message;

class MessageTest extends \PHPUnit_Framework_TestCase
{
	private $message;
	
	public function setUp()
	{
		$this->message = new Message();
	}
	
	public function testAsArrayIsEmpty() 
	{
		$this->assertEmpty($this->message->asArray());
	}
	
	public function testAsArrayIsOneProperty()
	{
		$this->message->setData('Test');
		$this->assertCount(1, $this->message->asArray());
	}
}