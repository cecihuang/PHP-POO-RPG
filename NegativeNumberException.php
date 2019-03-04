<?php

class NegativeNumberException extends Exception
{
	private $_message;
	
	function __construct($message, $code = 0)
	{
		$this->_message = $message;
	}
	
	function __toString()
	{
		return $this->_message;
	}
}
