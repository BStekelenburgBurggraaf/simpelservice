<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	session_start();
	if($_SESSION["logid"] == "" || $_SESSION["logid"] == NULL)
	{
		header("Location: login.php");	
	}
?>