<?php 

class Inventory{
	var $_inventory;
	public function __construct(){
		$this->_inventory= array();
	}
	public function getInventory(){
		return $this->_inventory;
	}
	public function addObject($object){
		$object= unserialize($object);
		$this->_inventory[$object->getName()]=$object;
	}
	public function delObject($object){
		try
		{
			FormatRequire::positiveInteger($this->getObject($object)->supNumber());
			$this->getObject($object)->supNumber();
		}
		catch (NegativeNumberException $e)
		{
			$this->getObject($object)->setNumber(0);
		}
	}
	public function getObject($object){
		return $this->getInventory()[$object];
	}
	public function randomObject(){
		$numberObject = rand(0,5);
		$object = null; 
		for($i=0;$i<$numberObject;$i++){
			$randomObject = rand(0,2);
			switch ($randomObject){
				case 0:
					if(!isset($this->_inventory["Small health potion"])){
						$object = new Potion5();
						$serialize = serialize($object);
						$this->addObject($serialize);
					}
					else
						$this->_inventory["Small health potion"]->addNumber();
				break;
				case 1:
					if(!isset($this->_inventory["Big health potion"])){
						$object = new Potion10();
						$serialize = serialize($object);
						$this->addObject($serialize);
					}
					else
						$this->_inventory["Big health potion"]->addNumber();
				break;
				case 2:
					if(!isset($this->_inventory["Resurrection parchment"])){
						$object = new Resurect();
						$serialize = serialize($object);
						$this->addObject($serialize);
					}
					else
						$this->_inventory["Resurrection parchment"]->addNumber();
				break;
			}
		}
	}
}