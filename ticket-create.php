<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include("includes/log-check.php");

if($_POST)
{
	//Connect to database
	include_once('database/database.php');
	
	$query = "INSERT INTO tickets (title, description,  priority, user_id, bedrijf_id) VALUES ('".$_POST["title"]."', '".$_POST["description"]."', '".$_POST["priority"]."', ".$_SESSION["logid"].", ".$_SESSION["bedrijf_id"].")";
	$result = mysql_query($query);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/form.css">
	<title>SimpelService - Ticket invoeren</title>
</head>

<body>
	<form action="ticket-create.php" method="post">
      	<div class="container">
        	<label><b>Titel</b></label>
        	<input type="text" placeholder="Enter Title" name="title" required>
    
        	<label><b>Omschrijving</b></label>
        	<textarea name="description" required="required"></textarea>
            
            <label><b>Prioriteit</b></label>
            <select name="priority">
            	<option value="urgent">Urgent</option>
                <option value="normaal" selected>Normaal</option>
                <option value="kan wachten">Kan Wachten</option>
            </select>
    
        	<button type="submit">Versturen</button>
      	</div>
    
      	<div class="container" style="background-color:#f1f1f1">
      	</div>
	</form>
</body>
</html>