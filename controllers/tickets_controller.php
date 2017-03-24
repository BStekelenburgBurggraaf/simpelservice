<?php
	class TicketsController {
		// /simpelservice/tickets/home/{id}
		public static function create() {
			//Check of de form ingevuld en verstuurd is
			if ($_POST) {
				if(isset($_FILES) && $_FILES["images"]["name"][0] != '') {
					$fileNames = Ticket::uploadImages($_FILES);
				} else {
					$fileNames = '';
				}
				if(isset($_POST["visible"])) {
					$visible = $_POST["visible"];
				} else {
					$visible = "zichtbaar";
				}
				$ticket = Ticket::create($_SESSION["id"], $_POST["title"], $_POST["content"], $_POST["category"], $_POST["priority"], $_POST["board_id"], $visible, $fileNames);
			}
			//Kijk of er een id is meegegeven, zo niet, stuur dan terug naar het hoofdscherm
			if(isset($_GET["id"]) && $_GET["id"] != "") {
				$board_id = $_GET["id"];
				$role = Ticket::getUserType($_SESSION["id"]);
				$categories = Ticket::getCategories();
				require_once("views/tickets/create.php");
			} else {
				header("Location: /simpelservice/boards/home");
			}
		}
		
		public function show() {
			if(!isset($_GET["id"]) || $_GET["id"] == "") {
				return call("errors", "error");	
			}
			
			$ticket = Ticket::show($_GET["id"]);
			$role = Ticket::getUserType($_SESSION["id"]);
			if ($role == "admin") {
				$subscribedUsers = Ticket::getSubscribedUsers($_GET["id"]);
			}
			require_once("views/tickets/show.php");
		}
		
		public function edit() {
			if(!isset($_GET["id"]) || $_GET["id"] == "") {
				return call('errors', 'error');
			}
			if($_POST) {
				if(isset($_POST["closeDescription"])){
					$ticket = Ticket::updateTicket($_GET["id"], $_POST["status"], $_POST["closeDescription"]);
					$mail = Ticket::getMailInfo($_GET["id"]);
				} else {
					$ticket = Ticket::updateTicket($_GET["id"], $_POST["status"], '');
					if (isset($_POST["mail"])) {
						$mail = Ticket::getMailInfo($_GET["id"]);	
					}
				}
				if(isset($mail)) {
					$to = $mail["to"];
					if ($mail["status"] == "closed") {
						$subject = "Ticket gesloten: " . $mail["title"];
					} else {
						$subject = "Ticket gewijzigd: " . $mail["title"];	
					}
					$message = '
					<html>
					<head>
					  <title>Update ticket: '.$mail["title"].'</title>
					</html>
					<body>
					  <h3>'. $mail["title"] .'</h3>
					  <hr>
					  <p><b>Content:</b><br/>'.$mail["description"].'</br>
					  <p><b>Status:</b><br/>'.$mail["status"].'</br>
					</body>
					';
					
					$headers[] = 'MIME-Version: 1.0';
					$headers[] = 'Content-type: text/html; charset=iso-8859-1';
					$headers[] = 'From: SimpelService <b.stekelenburg@burggraaf.nl>';
					//mail($to, $subject, $message, implode("\r\n", $headers));	
				}
				header("Location: /simpelservice/boards/home");
			}
			
			$tickets = Ticket::getTicket($_GET["id"]);
			$categories = Ticket::getCategories();
			require_once("views/tickets/edit.php");
		}
		
		public function addUsers() {
			if ($_POST) {
				Ticket::updateSubscribers($_POST["result"]["id"], $_POST["result"]["checked"]);
			}
			$ticket = Ticket::getTicketCompany($_GET["id"]);
			$users = Ticket::getEmployees($ticket[0]);
			require_once("views/tickets/addUsers.php");
		}
	}
?>