<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
session_start();

if($_POST)
{
	//Connect to database
	include_once('database/database.php');
	$query = "SELECT password, id, username FROM users WHERE username = '".$_POST["uname"]."'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if($_POST["psw"] == $row["password"])
	{
		$_SESSION["logid"] = $row["id"];
		header("Location: index.php");	
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <title>SimpelService - Inloggen</title>
</head>
<body>
	<form action="login.php" method="post">
      	<div class="container">
        	<label><b>Username</b></label>
        	<input type="text" placeholder="Enter Username" name="uname" required>
    
        	<label><b>Password</b></label>
        	<input type="password" placeholder="Enter Password" name="psw" required>
    
        	<button type="submit">Login</button>
        	<!--<input type="checkbox" checked="checked"> Remember me-->
      	</div>
    
      	<div class="container" style="background-color:#f1f1f1">
        	<span class="psw">Forgot <a href="#">password?</a></span>
      	</div>
	</form>
</body>
</html>