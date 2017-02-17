<?php
	//Maak verbinding met het datbase.
	require_once "connection.php";
	$db = Db::getInstance();
	//Stel de SQL query samen.
	//SUBDATE(NOW(), INTERVAL 1 WEEK) zorgt ervoor dat hij de huidige tijd vergelijkt met alle laatste update entries van de tickets, als het ouder of gelijk is aan 1 week, zal hij ze terug geven
	$req = $db->prepare("SELECT * FROM tickets WHERE last_update <= SUBDATE(NOW(), INTERVAL 1 WEEK) AND status != 'closed'");
	//Voer de waardes in op de juiste plekken en voer de query uit.
	$req->execute();
	
	//Voor alle tickets die ouder dan 2 weken zijn, stuur een mail naar personeel dat bij deze borden horen.
	foreach($req->fetchAll() as $ticket) {
		$boardId = $ticket["board_id"];
		$req2 = $db->prepare("SELECT * FROM boards WHERE id = :id");
		$req2->execute(array('id' => $boardId));
		$board = $req2->fetch();
		$boardName = $board["title"];
		
		$i = 0;
		$to = "";
		$req3 = $db->prepare("SELECT * FROM users WHERE board_subscriptions LIKE '% $boardId,%' AND status = 'personeel';");
		$req3->execute();
		foreach($req3->fetchAll() as $user) {
			if ($i == 0) {
				$to = $user["email"];
				$i = 1;
			} else { 
				$to .= ", " . $user["email"];
			}
		}
		
		$subject = "Reminder ticket: " . $ticket["title"];
		$message = '
		<html>
		<head>
		  <title>New ticket: '.$ticket["title"].'</title>
		</html>
		<body>
		  <h3>'. $ticket["title"] .'</h3>
		  <hr>
		  <p><b>Prioriteit:</b> '.$ticket["priority"].'</p>
		  <p><b>Board:</b> '.$boardName.'</p>
		  <p><b>Content:</b><br/>'.$ticket["description"].'
		</body>
		';
		
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		$headers[] = 'From: SimpelService <b.stekelenburg@burggraaf.nl>';
		mail($to, $subject, $message, implode("\r\n", $headers));
	}
?>