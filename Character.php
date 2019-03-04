<?php
abstract class Character
{
	private $_name;
	private $_hp;
	private $_max_hp;
	private $_pow;
	private $_xp;
	private $_classe;
	private $_has_attacked;
	
	//abstract function superFunction();
	
	function __construct($name, $hp, $pow, $xp,$classe)
	{
		$this->_name = $name;
		$this->_hp = $hp;
		$this->_max_hp = $hp;
		$this->_pow = $pow;
		$this->_xp = $xp;
		$this->_classe = $classe;
		$this->_has_attacked = false;
	}
	function getHas_attacked(){
		return $this->_has_attacked;
	}
	function setHas_attacked($bool){
		$this->_has_attacked =$bool;
	}
	function attack(Character $defenser)
	{
		if ($defenser === $this)
			return 'You can\'t shoot yourself';
		if ($defenser->getHp() <= 0)
			return 'You can\'t shoot a dead man';
		if ($this->getHp() <= 0)
			return 'You can\'t shoot if you\'re dead';
		$defenser->receiveDamage($this->getPow());
		$this->gainXp();
		$this->setHas_attacked(true);
		return "ok";
	}
	
	function receiveDamage($pow)
	{
		$this->setHp($this->getHp() - $pow);
	}
	function gainHp($hp)
	{
		if($this->getHp() + $this->getPow() <= $this->getMax_hp())
			$this->setHp($this->getHp() + $hp);
		else 
			$this->setHp($this->getMax_hp());
	}
	
	function gainXp()
	{
		$this->setXp($this->getXp() + 1);
		if ($this->getXp() % 3 == 0)
			$this->setPow($this->getPow() + 1);
	}
	
	function getName()
	{
		return $this->_name;
	}
	
	function setHp($hp)
	{
		try
		{
			FormatRequire::positiveInteger($hp);
			$this->_hp = $hp;
		}
		catch (NegativeNumberException $e)
		{
			$this->_hp = 0;
		}
	}
	
	
	function addHp($hp)
	{
		if($this->getHp()+$hp>$this->getMax_hp())
			$this->_hp = $this->getMax_hp();
		else
			$this->_hp += $hp;
	}
	function getHp()
	{
		return $this->_hp;
	}
	
	function setMax_hp($hp)
	{
		try
		{
			FormatRequire::positiveInteger($hp);
			$this->_max_hp = $hp;
		}
		catch (NegativeNumberException $e)
		{
			$this->_max_hp = 0;
		}
	}
	
	function getMax_hp()
	{
		return $this->_max_hp;
	}
	
	function setXp($xp)
	{
		FormatRequire::positiveInteger($xp);
		$this->_xp = $xp > 0 ? $xp : 0;
	}
	
	function getXp()
	{
		return $this->_xp;
	}
	
	function setPow($pow)
	{
		FormatRequire::positiveInteger($pow);
		$this->_pow = $pow > 0 ? $pow : 0;
	}
	
	function getPow()
	{
		return $this->_pow;
	}
	function getClass(){
		return $this->_classe;
	}
}
