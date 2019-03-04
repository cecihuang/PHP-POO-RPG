<?php
	session_start();
	spl_autoload_register(function($class){require $class .'.php';});
	if (isset($_SESSION['game']))
	{
		header('Location:index.php');
		exit();
	}

	if(isset($_FILES["test_download"])){
		$_SESSION['game']=unserialize(file_get_contents ($_FILES["test_download"]['tmp_name']));
		header('Location:index.php');
		exit();
	}

	if(isset($_POST['submit'])){
		$_SESSION['game'] = new Game;
		$_SESSION['game']->addCharacter($_POST['nom'],$_POST['classe']);
		header('Location:index.php');
	}
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Document sans titre</title>
	</head>
	<body>
		<style>
			h2{text-align: center}
			button,input[type=button],input[type=submit]{padding:5px 10px!important}
			p{text-align:center}
			form{text-align: center}
			div{float:left;width:33.33%}
			select,input[type=text],label{min-width:200px;margin:5px}
		</style>
		<p>Hello player, welcome to the infinite tower! You have been locked out with your comrade and there is apparently no exit in that tower. You will have to go through all the rooms and beat up numerous beast. The Main mission is to defeat the boss of the first part of the tower in room 10. the tower is an open world, you can decide to skip all the battle and meet up the big boss (who is obviously much stronger than you). And the end of the mission you can chose if you want to continue the game (the following rooms aren't in the mini map). Good luck !</p>
		<form method="post">
			<legend>Create a new game</legend>
			<label>Your name : </label>
			<input type="text" name="nom"><br>
			<label>You are: </label>
			<select name="sexe">
				<option>Man</option>
				<option>Women</option>
				<option>Both ? :p</option>
			</select><br>
			<label>Your feature : </label>
			<select name="classe">
				<option>Knight</option>
				<option>Wizard</option>
				<option>Vampire</option>
			</select><br>
			<button type="submit" name="submit">Go !</button>
		</form>
		<p>OR</p>
		<form enctype="multipart/form-data" method="post">
			<legend>Load a save file</legend>
			<label>Your file : <input type="file" name="test_download"></label><br>
			<button>Go !</button>
		</form>
		<p>Details on the rank : </p>
		<div>
			<h2>Knight</h2>
			<p>50 pv<br>5 damages<br>gain 2 xp per turn</p>
		</div>
		<div>
			<h2>Vampire</h2>
			<p>30 pv<br>7 damages<br>gain 1 xp per turn<br>Special ability : Life Steal </p>
		</div>
		<div>
			<h2>Wizard</h2>
			<p>40 pv<br>10 damages<br>gain 1 xp per turn</p>
		</div>
	</body>
</html>