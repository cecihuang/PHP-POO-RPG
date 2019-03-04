<?php 
class Zombie extends Character{
	function __construct($name,$hp=0,$pow=0,$xp=0){
		parent::__construct($name,$hp,$pow,$xp,"Zombie");
	}
	function attack(Character $defenser)
	{
		$message = parent::attack($defenser);
		return ($message == "ok")? $this->getName() . ' smahed ' . $defenser->getName() : $message;
	}
	
	function gainXp()
	{
		$this->setXp($this->getXp() + 2);
		if ($this->getXp() % 3 == 0)
			$this->setPow($this->getPow() + 1);
	}
}
?>