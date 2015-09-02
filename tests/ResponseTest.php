<?php

namespace test;

use oxidpion\gcm\Message;
use oxidpion\gcm\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
	private $response;
	
	protected function setUp()
	{
		$message = new Message();
		$message->setRegistrationIds(array(1, 2, 3, 4, 5, 6));
		$response = 
		'{ "multicast_id": 216,
            "success": 3,
            "failure": 3,
            "canonical_ids": 1,
            "results": [
              { "message_id": "1:0408" },
              { "error": "Unavailable" },
              { "error": "InvalidRegistration" },
              { "message_id": "1:1516" },
              { "message_id": "1:2342", "registration_id": "32" },
              { "error": "NotRegistered"}
            ]
        }';
		$this->response = new Response($message, $response);
	}
	
    public function testGetNewRegistrationIds()
    {	
        $this->assertEquals(array(5 => 32), $this->response->getUpdate());
    }
    
    public function testGetInvalidRegistrationIds()
    {
        $this->assertEquals(array(3, 6), $this->response->getRemove());
    }
    
    public function testGetUnavailableRegistrationIds()
    {
        $this->assertEquals(array(2), $this->response->getUnavailable());
    }
}