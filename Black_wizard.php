<?php 
class Black_wizard extends Character{
	function __construct($name,$hp=0,$pow=0,$xp=0){
		parent::__construct($name,$hp,$pow,$xp,"Black Wizard");
	}
	function attack(Character $defenser)
	{
		$message = parent::attack($defenser);
		return ($message == "ok")? $this->getName() . ' smahed ' . $defenser->getName() : $message;
	}
}
?>