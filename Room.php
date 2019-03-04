<?php

class Room{
	private $_num_room;
	private $_beasts;
	private $_is_clear;
	private $_turn;
	private $_turnWho;
	function __construct($numRoom,$xp){
		$this->_num_room = $numRoom;
		$this->_is_clear=false;
		$this->_beasts = new Beast($numRoom,$xp);
		$this->_turnWho = 'Gamers';
		$this->_turn = 1;
	}
	
	public function addTurn(){
		$this->_turn++;
	}
	public function getTurn(){
		return $this->_turn;
	}
	public function getTurnWho(){
		return $this->_turnWho;
	}
	public function setTurnWho($turnWho){
		$this->_turnWho = $turnWho;
	}
	function getNum_room(){
		return $this->_num_room;
	}
	function setNum_room($numRoom){
		$this->_num_room=$numRoom;
	}
	function getIs_clear(){
		return $this->_is_clear;
	}
	function setIs_clear($boolean){
		$this->_is_clear=$boolean;
	}
	function getBeasts(){
		return $this->_beasts;
	}
}