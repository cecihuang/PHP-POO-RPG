<?php 

class Vampire extends Character{
	function __construct($name)
	{
		parent::__construct($name,30,7,0,"Vampire");
	}
	function attack(Character $defenser)
	{
			$message = parent::attack($defenser);
			if($this->getPow()<$defenser->getHp())
				$this->gainHp($this->getPow());
			else
				$this->gainHp($defenser->getHp());
			return ($message == "ok")? $this->getName() . ' sucks ' . $defenser->getName().'\'s blood' : $message;
	}
}