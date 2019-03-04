<?php
	spl_autoload_register(function($class){require $class .'.php';});
	session_start();

	$str = serialize($_SESSION['game']);

	header('Content-Disposition: attachment; filename="sample.txt"');
	header('Content-Type: text/plain'); 

	echo $str;