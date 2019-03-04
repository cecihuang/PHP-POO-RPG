<?php
spl_autoload_register(function($class){require $class .'.php';});
session_start();
$game = $_SESSION['game'];
if (isset($_POST['attacker'], $_POST['defenser']))
	$_session['message']  = $game->makeAttack($_POST['attacker'], $_POST['defenser']);

if (isset($_POST['atk']))
	$_session['message'] = $game->makeRandomAttack($_POST['atk']);
header('Location:index.php');
exit();
?>