<?php
class Game
{
	private $_characters;
	private $_rooms;
	private $_current_room;
	private $_cycle;
	private $_gameWon;
	private $_inventory;
	
	public function __construct()
	{
		$this->_characters = [
				'Dracula' => new Vampire('Dracula', 10, 1, 0),
				'Lancelot' => new Knight('Lancelot', 4, 2, 0),
				'Gandalf' => new Wizard('Gandalf', 10, 1, 0)
			];
		$this->_current_room = 1;
		$this->_cycle = 'Day';
		$this->_rooms = [
				new Room($this->_current_room,0)
			];
		$this->_gameWon = false;
		$this->_inventory = new Inventory();
	}
	public function getRooms()
	{
		return $this->_rooms;
	}
	public function getRoom($room)
	{
		return $this->getRooms()[$room];
	}
	public function addRoom($numSalle,$room)
	{
		$this->_rooms[$numSalle] =$room;
	}
	public function getCharacters(){
		return $this->_characters;
	}
	public function getCharacter($character){
		return $this->getCharacters()[$character];
	}
	public function addCharacter($nom,$classe)
	{
		switch($classe){
			case "Vampire": 
				$character = new Vampire($nom);
			break;
			case "Knight": 
				$character = new Knight($nom);
			break;
			case "Wizard": 
				$character = new Wizard($nom);
			break;
		}
		$this->_characters[$nom] =$character;
	}
	public function getCurrent_room()
	{
		return $this->_current_room;
	}
	public function setCurrent_room($room)
	{
		$this->_current_room = $room;
	}
	
	public function getBeasts()
	{
		return $this->getRoom($this->getCurrent_room()-1)->getBeasts();
	}
	
	public function getBeast($beast)
	{
		return $this->getBeasts()[$beast];
	}
	
	public function addBeast($nom,$classe)
	{
		switch($classe){
			case "Goblin": 
				$beast = new Goblin($nom);
			break;
			case "Zombie": 
				$beast = new Zombie($nom);
			break;
			case "Black_wizard": 
				$beast = new Black_wizard($nom);
			break;
		}
		$this->_beasts[$nom] =$beast;
	}
	public function makeAttack($attacker, $defenser)
	{
		$attack_response=$this->getCharacter($attacker)->attack($this->getBeasts()->getCharacter($defenser));
		
		if($attack_response!='You can\'t shoot yourself' && $attack_response!= 'You can\'t shoot a dead man' && $attack_response !='You can\'t shoot if you\'re dead'){
			echo $attack_response; 
			$this->checkTurn();
			$this->checkbattleEnd();
		}
	}
	public function makeRandomAttack($attacker)
	{
		$characters = array_values($this->getAliveCharacter());
		$defenser = $characters[rand(0,count($characters)-1)]->getName();
		$attack_response= $this->getBeasts()->getCharacter($attacker) ->attack($this->getCharacter($defenser));
		if($attack_response!='You can\'t shoot yourself' && $attack_response!= 'You can\'t shoot a dead man' && $attack_response !='You can\'t shoot if you\'re dead'){
			$message = $attack_response;
			$this->checkTurn();
			$message .= '<br>'.$this->checkbattleEnd();
			return $message;
		}
	}
	public function getCycle(){
		return $this->_cycle;
	}
	public function changeCycle(){
		$this->_cycle = ($this->getCycle()=='Day')?'Night':'Day';
		if($this->_cycle == 'Day'){
			foreach($this->getCharacters() as $character){
				
			}
		}
	}
	public function checkTurn(){
		$currentTurnWho = $this->getRoom($this->getCurrent_room()-1)->getTurnWho();
		if($this->getRoom($this->getCurrent_room()-1)->getTurnWho() == 'Gamers'){
			foreach($this->getCharacters() as $character){
				if($character->getHas_attacked() == true || ($character->getHp() == 0 && $character->getHas_attacked() != true)){
					$this->getRoom($this->getCurrent_room()-1)->setTurnWho('Beasts');
				}
				else{
					$this->getRoom($this->getCurrent_room()-1)->setTurnWho('Gamers');
					return false;
				}
			}
		}
		else{
			foreach($this->getBeasts()->getBeast() as $beast){
				if($beast->getHas_attacked() == true || ($beast->getHp() == 0 && $beast->getHas_attacked() != true)){
					$this->getRoom($this->getCurrent_room()-1)->setTurnWho('Gamers');
				}
				else{
					$this->getRoom($this->getCurrent_room()-1)->setTurnWho('Beasts');
					return false;
				}
			}
		}
		if($currentTurnWho !=$this->getRoom($this->getCurrent_room()-1)->getTurnWho()){
			$this->reloadTurn($currentTurnWho);
		}
	}
	public function resetCharacter(){
		foreach($this->getCharacters() as $character){
			$character->setHas_attacked(false);
		}
		foreach($this->getBeasts()->getBeast() as $beast){
			$beast->setHas_attacked(false);
		}
	}
	public function getAliveCharacter(){
		$aliveCharacter=array();
		foreach($this->getCharacters() as $character){
			if($character->getHp()!=0){
				$aliveCharacter[]=$character;
			}
		}
		return $aliveCharacter;
	}
	public function reloadTurn($currentTurn){
		$this->getRoom($this->getCurrent_room()-1)->addTurn();
		if($this->getRoom($this->getCurrent_room()-1)->getTurn()%6==0){
			$this->changeCycle();
		}
		if($currentTurn == 'Gamers'){
			foreach($this->getCharacters() as $character){
				$character->setHas_attacked(false);
			}
		}
		elseif($currentTurn== 'Beasts'){
			foreach($this->getBeasts()->getBeast() as $beast){
				$beast->setHas_attacked(false);
			}
		}
	}
	public function useObject($object){
		$not_used = true;
		foreach ($this->getCharacters() as $c){ 
			switch($object){
				case "Small health potion":
					if($c->getHp()>0){
						$heal = $this->getInventories()->getObject($object)->getAttrib();
						$c->addHp($heal);
						$not_used = false;
					}
				break;
				case "Big health potion":
					if($c->getHp()>0){
						$heal = $this->getInventories()->getObject($object)->getAttrib();
						$c->addHp($heal);
						$not_used = false;
					}
				break;
				case "Resurrection parchment":
					if($c->getHp()==0){
						$c->setHp($c->getMax_hp());
						$not_used = false;
					}
				break;
			}
		}
		if($not_used == false)
		$this->getInventory($object)->supNumber();
	}
	public function getInventories(){
		return $this->_inventory;
	}
	public function getInventory($name){
		return $this->getInventories()->getInventory()[$name];
	}
	public function checkbattleEnd(){
		$check_dead_beast = true;
		$check_dead_caracter = true;
		foreach($this->getBeasts()->getBeast() as $beast){
			if($beast->getHp()!=0)
				$check_dead_beast = false;
		}
		foreach($this->getCharacters() as $character){
			if($character->getHp()!=0)
				$check_dead_caracter = false;
		}
		if($check_dead_caracter == true) {
			return "Game Over !";
		}
		else if($check_dead_beast == true) {
			$this->getInventories()->randomObject();
			$this->getRoom($this->getCurrent_room()-1)->setIs_clear(true);
			return "You won this battle, go to next room !";
		}
	}
}

?>
