<?php 

class Wizard extends Character{
	function __construct($name)
	{
		parent::__construct($name,40,10,0,"wizard");
	}
	function attack(Character $defenser)
	{
		$message = parent::attack($defenser);
		return ($message == "ok")? $this->getName() . ' shoots a fire ball on ' . $defenser->getName() : $message;
	}
}