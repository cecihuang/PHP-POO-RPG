<?php

class FormatException extends Exception{
	
	private $_message;
	function __construct($message, $code = 0){
		$this->_message = $message;
	}
	function toString(){
		return $this->_message;
	}
}