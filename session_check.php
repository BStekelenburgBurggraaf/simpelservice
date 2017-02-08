<?php
	session_start();
	if($controller != "login" && $action != "login"){
		if(!isset($_SESSION["log"]))
			header("Location: ?controller=login&action=login");
	}
?>