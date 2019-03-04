<?php 

class Knight extends Character{
	function __construct($name)
	{
		parent::__construct($name,50,5,0,"Knight");
	}
	function attack(Character $defenser)
	{
		$message = parent::attack($defenser);
		return ($message == "ok")? $this->getName() . ' slice ' . $defenser->getName() : $message;
	}
	
	function gainXp()
	{
		$this->setXp($this->getXp() + 2);
		if ($this->getXp() % 3 == 0)
			$this->setPow($this->getPow() + 1);
	}
}