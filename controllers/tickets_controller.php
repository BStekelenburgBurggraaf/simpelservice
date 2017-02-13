<?php
	class TicketsController {
		public static function create() {
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
			$board_id = $_GET["id"];
			$role = Ticket::getUserType($_SESSION["id"]);
			require_once("views/tickets/create.php");
		}
		
		public function show() {
			if(!isset($_GET["id"]))
				return call('errors', 'error');
				
			
		}
	}
?>