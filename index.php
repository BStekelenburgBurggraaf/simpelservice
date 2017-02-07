<?php
session_start();
if($_SESSION["log"] == "" || $_SESSION["log"] == NULL)
{
	header("Location: login.php");
}