<?php
	class Beast {
		private $_beast;
		function __construct($numRoom,$pow){
			if($numRoom!=9){
				$val = ($pow%3);
				$nb_beasts=rand (2,6);
				for($i=1;$i<=$nb_beasts;$i++){
					$type_beast=rand (1,3);
					switch($type_beast){
						case 1:
							$this->_beast["Beast ".$i] = new Zombie("Beast ".$i,45+$val,2+$val,0+$val*2);
						break;
						case 2:
							$this->_beast["Beast ".$i] = new Black_wizard("Beast ".$i,25+$val,10+$val,0+$val);
						break;
						case 3:
							$this->_beast["Beast ".$i] = new Goblin("Beast ".$i,25+$val,5+$val,0+$val);
						break;

					}
				}
			}
			else{
				$val = ($pow%3);
				$this->_beast["Alexandre Tsu Manuel"] = new Demon("Alexandre Tsu Manuel",500+$val,2+$val,0+$val);
			}
		}
		function getBeast(){
			return $this->_beast;
		}
		public function getCharacter($character)
		{
			return $this->getBeast()[$character];
		}
	}
?>