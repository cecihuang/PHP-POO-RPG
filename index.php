<?php
spl_autoload_register(function($class){require $class .'.php';});
session_start();

if (isset($_GET['reset']) || !isset($_SESSION['game']))
{
	session_destroy();
	header('Location:create_game.php');
	exit();
}
if(isset($_SESSION['message'])){
	$message = $_SESSION['message'];
	unset($_SESSION['message']);	
}
$game = $_SESSION['game'];
if(isset($_GET['use'])){
	if($game->getInventory(str_replace('_',' ',$_GET['use']))->getNumber()>0){
		$game->useObject(str_replace('_',' ',$_GET['use']));
	}
	else{
		$message="Used it all !";
	}
}

if(isset($_GET['toss'])){
	if($game->getInventory(str_replace('_',' ',$_GET['toss']))->getNumber()>0){
		$game->getInventory(str_replace('_',' ',$_GET['toss']))->supNumber();
		
	}
	else{
		$message="Used it all !";
	}
}

if(isset($_GET['room'])){
	if(!isset($game->getRooms()[$_GET['room']])){
		$game->addRoom($_GET['room'],new Room($_GET['room'],$_GET['exp']));
		$game->setCurrent_room($_GET['room']+1);
		$game->resetCharacter();
		$game->getRoom($game->getCurrent_room()-1)->setTurnWho("Gamers");
	}
	else{
		$game->setCurrent_room($_GET['room']+1);
		$game->resetCharacter();
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>RPG</title>
	</head>
	<body>
		<style>
			*{margin:0;padding:0}
			table{margin:0 auto;text-align: center}
			h2{text-align: center}
			td,table { border : 1px solid black}
			.mini_map tr td { width: 50px;height:50px;}
			button,input[type=button],input[type=submit]{padding:5px 10px!important}
			p{text-align:center}
			nav{box-shadow: 10px 10px 5px grey;padding: 10px;margin-bottom:10px}
			nav a button{float:right;margin-top:15px;margin-right:5px}
		</style>
		<nav>
			<a href="?reset"><button>Reset</button></a>
			<a href="save.php" ><button>Save</button></a>
			<?php if($game->getCurrent_room()==10){ ?>
				<audio controls loop <?php if( $game->getRoom($game->getCurrent_room()-1) == 1){ ?> autoplay <?php } ?>> 
					<source src="music/jdg-le-mechant.mp3">
				</audio>
			<?php }
			else{ ?>
				<audio controls loop> 
					<source src="music/Undertale Undyne The Undying Theme  ( Battle Against A True Hero ).mp3">
				</audio>
			<?php } ?>
		</nav>
		<h1 style="text-align:center">Room <?= $game->getCurrent_room() ?> Turn <?= $game->getRoom($game->getCurrent_room()-1)->getTurn() ?> <?= $game->getCycle() ?></h1>
		
		<?php
		if (isset($message))
			echo '<p style="font-weight: bold">', $message, '</p>';
		?>
		<h2>Mini-map</h2>
		<table class="mini_map">
			<tr>
				<?php for($i=0;$i<10;$i++){ 
					if($i+1 == $game->getCurrent_room()){ ?>
						<td><a nohref>You are Here</a></td>
					<?php }
					else{ ?>
						<td><a <?php if($game->getCurrent_room()!=10){ ?>href="?room=<?= $i ?>&exp=<?= $game->getCharacters()["Gandalf"]->getXp() ?>"<?php }else echo "nohref" ?>>Go to room <?= $i+1 ?></a></td>
					<?php }
				 } ?>
			</tr>
		</table>
		<form method="post" action="control.php">
			<div style="float:left;width:45%">
				<h2 >Players</h2>
				<table>
					<tr>
						<td>Players</td>
						<?php foreach ($game->getCharacters() as $c){ ?>
							<td>
								<?=$c->getName()?>
							</td>
						<?php } ?>
					</tr>
					<tr>
						<td>Stats</td>
						<?php foreach ($game->getCharacters() as $c){ ?>
							<td><?=$c->getHp()?>/<?=$c->getMax_hp()?> HP<br><?=$c->getPow()?> Power<br><?= $c->getXp() ?> XP<br>Rank : <?=$c->getClass()?></td>
						<?php } ?>
					</tr>
					<tr>
						<td>Action</td>
						<?php foreach ($game->getCharacters() as $c){ ?>
							<td>
								<label>attack ! <input type="radio" name="attacker" value="<?=$c->getName()?>" <?= ($game->getRoom($game->getCurrent_room()-1)->getIs_clear()!=false ||$c->getHas_attacked()!=false || $game->getRoom($game->getCurrent_room()-1)->getTurnWho()=="Beasts" || $c->getHp() == 0)? "disabled":"" ?>>
								</label>
							</td>
						<?php } ?>
					</tr>
				</table>
			</div>
			<div style="width:45%;float: right">
				<h2>Beast</h2>
				<table>
					<tr>
						<td>Beast</td> 
						<?php 
						foreach ($game->getBeasts()->getBeast() as $b){ ?>
							<td>
								<?=$b->getName()?>
								<?php if($game->getCurrent_room()==10){ ?> <br><img src="img/Demon.jpg" style="width:150px;height:auto"> <?php } ?>
							</td>
						<?php } ?>
					</tr>
					<tr>
						<td>Stats</td>
						<?php foreach ($game->getBeasts()->getBeast() as $b){ ?>
							<td><?=$b->getHp()?>/<?=$b->getMax_hp()?> HP<br><?=$b->getPow()?> Power<br>Rank : <?=$b->getClass()?></td>
						<?php }  ?>
					</tr>
					<tr>
						<td>Action</td>
						<?php foreach ($game->getBeasts()->getBeast() as $b){ ?>
							<td>
								<label>attack ! <input type="radio" name="defenser" value="<?=$b->getName()?>" <?= ($game->getRoom($game->getCurrent_room()-1)->getIs_clear()!=false ||$game->getRoom($game->getCurrent_room()-1)->getTurnWho()=="Beasts" || $b->getHp() == 0)? "disabled":"" ?>>
								</label><br>
								<button type="submit" name="atk" value="<?= $b->getName() ?>" <?= ($game->getRoom($game->getCurrent_room()-1)->getIs_clear()!=false ||$b->getHas_attacked()!=false || $game->getRoom($game->getCurrent_room()-1)->getTurnWho()!="Beasts" || $b->getHp() == 0)? "disabled":"" ?>>Ramdom attack</button>
							</td>
						<?php } ?>
					</tr>
				</table>
			</div>
			<input type="submit" value="Launch attack" style="margin-top:70px;" <?php if($game->getRoom($game->getCurrent_room()-1)->getTurnWho()=="Beasts" ||$game->getRoom($game->getCurrent_room()-1)->getIs_clear()!=false) {?> disabled <?php } ?> />
			<?php if($game->getRoom($game->getCurrent_room()-1)->getIs_clear()!=false) {?>
			<p>You won !</p><a href="?room=<?= $game->getCurrent_room() ?>&exp=<?= $game->getCharacters()["Gandalf"]->getXp() ?>"><input type="button" value="Go to next room" /></a><?php } ?>
		</form>
		<div style="margin-top:100px;">
		<h2>Inventaire</h2>
			<table class="Inventory">
				<tr>
					<td>Object</td>
					<td>Number</td>
					<td>Description</td>
					<td>Actions</td>
				</tr>
				<?php foreach($game->getInventories()->getInventory() as $object){ ?>
					<tr>
						<td><?= $object->getName() ?></td>
						<td><?= $object->getNumber() ?></td>
						<td><?= $object->getDesc() ?></td>
						<td><a <?= ($object->getNumber()==0)?"no":"" ?>href="?use=<?= str_replace(' ','_',$object->getName()) ?>"><button <?= ($object->getNumber()==0)?"disabled":"" ?>>Use</button></a><a <?= ($object->getNumber()==0)?"no":"" ?>href="?toss=<?= str_replace(' ','_',$object->getName()) ?>" ><button <?= ($object->getNumber()==0)?"disabled":"" ?>>Toss 1</button></a></td>
					</tr>
				<?php } ?>
			</table>
		</div>
		<p style="margin-top:20px">How to play : When it's your turn, select the character you intent to play with (by clicking on the input type radio with the button attack) and select the beast you wanna hit by clicking on the same input. When you have finished your turn, you will have to click on every Random attack button in order to make them attack (it's a more RPG choice for me, I prefer to let the user see every interaction he can make). By playing in this game, you drop some artefacts that the beasts dropped when they died, use them well !</p>
	</body>
</html>