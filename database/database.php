<?php
	require_once('database/database-config.php');
		
	$db = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Kan niet verbinden: ".mysql_error());
	mysql_select_db(DB_NAME, $db) or die (mysql_error());
?>