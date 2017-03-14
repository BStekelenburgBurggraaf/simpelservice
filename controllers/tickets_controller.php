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
				$ticket = Ticket::updateTicket($_GET["id"], $_POST["status"]);
				header("Location: /simpelservice/baords/home");
			}
			
			$tickets = Ticket::getTicket($_GET["id"]);
			$categories = Ticket::getCategories();
			require_once("views/tickets/edit.php");
		}
	}
?>