<?php

namespace test;

use oxidpion\gcm\GCM;
use oxidpion\gcm\Exception;

class GCMTest extends \PHPUnit_Framework_TestCase
{
	private $gcm;
	
	public function setUp()
	{
		$this->gcm = new GCM();
	}
	
	public function tearDown()
	{
		unset($this->gcm);
	}
	
	public function testNewMessageShouldInstanceOfMessage()
	{
		$this->assertInstanceOf('oxidpion\gcm\Message', $this->gcm->newMessage());
	}
	
	/**
	 * @dataProvider providerApiKeyCheck
	 * @expectedException oxidpion\gcm\Exception
	 * @expectedExceptionCode 1
	 */
	public function testApiKeyCheck($a)
	{
		$this->gcm->setApiKey($a);
	}
	
	public function providerApiKeyCheck()
	{
		return array(
				array(null),	array(''),
				array(0),		array(false),
				array(true),
		);
	}
	
	public function testApiKeyCheckCorrect()
	{
		$this->assertEquals($this->gcm, $this->gcm->setApiKey("API KEY VALUE"));
	}
	
	/**
	 * @expectedException oxidpion\gcm\Exception
	 * @expectedExceptionCode 1 
	 */
	public function testApiKeyCheckWhenSend()
	{
		$this->gcm->newMessage();
		$this->gcm->send();
	}
}