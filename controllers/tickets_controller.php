<?php
	class TicketsController {
		public static function create() {
			if ($_POST) {
				$ticket = Ticket::create($_SESSION["id"], $_POST["title"], $_POST["content"], $_POST["category"], $_POST["priority"], $_POST["board_id"]);
			}
			$board_id = $_GET["id"];
			require_once("views/tickets/create.php");
		}
		
		public function show() {
			if(!isset($_GET["id"]))
				return call('errors', 'error');
				
			
		}
	}
?>