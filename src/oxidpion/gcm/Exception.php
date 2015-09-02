<?php

namespace oxidpion\gcm;

class Exception extends \Exception
{
	const ILLEGAL_API_KEY = 1;
	const ERROR_PROPERTY = 2;
	const MALFORMED_REQUEST = 3;
	const UTHENTICATION_ERROR = 4;
	
	const UNKNOWN_ERROR = 255; 
}