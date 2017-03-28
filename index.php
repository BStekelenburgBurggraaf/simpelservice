<?php
	require_once("connection.php");
	
	//Als er geen controller en action in de controller staan, ga dan naar de login pagina.
	if(isset($_GET["controller"]) && isset($_GET["action"])) {
		$controller = $_GET["controller"];
		$action = $_GET["action"];	
	} else {
		$controller = "login";
		$action = "login";	
	}
	
	require_once("session_check.php");
	require_once("views/layout.php");
?>