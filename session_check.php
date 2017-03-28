<?php
	//Controlleer of de user is ingelogd, zo niet, ga dan naar login
	session_start();
	if($controller != "login" && $action != "login"){
		if(!isset($_SESSION["log"]))
			header("Location: /simpelservice/login/login");
	}
?>