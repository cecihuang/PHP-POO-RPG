<?php 
abstract class InventoryObject{
	var $_name;
	var $_attribute;
	var $_description;
	var $_number;
	public function __construct($name,$attribute,$description){
		$this->_name = $name;
		$this->_attribute = $attribute;
		$this->_description = $description;
		$this->_number=1;
	}
	function getName(){
		return $this->_name;
	}
	function getNumber(){
		return $this->_number;
	}
	function addNumber(){
		$this->_number++; 
	}
	function supNumber(){
		$this->_number--;
	}
	function setNumber($number){
		$this->_number=$number;
	}
	function getAttrib(){
		return $this->_attribute;
	}
	function getDesc(){
		return $this->_description;
	}
	function getWork_on(){
		return $this->_work_on;
	}
}
?>