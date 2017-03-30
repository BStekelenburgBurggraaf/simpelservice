<?php
	class BoardsController {
		//simpelservice/boards/home/{x}, x is optioneel
		public function home() {
			$role = Board::getUserType($_SESSION["id"]);
			if($_GET["id"] != '') {
				$boards = Board::getBoards($_SESSION["id"], $_GET["id"]);
				$role = Board::getUserType($_SESSION["id"]);
				if ($role == "admin") {
					$subscribedUsers = Board::getSubscribedUsers($_GET["id"]);
				}
			} else {
				if(isset($_SESSION["logged"]) && $_SESSION["logged"] == "logged in") {
					$display = Board::getLoginType($_SESSION["id"]);
					if($display == "subscribed") {
						$boards = Board::filterUser($_SESSION["id"]);	
					} elseif($display == "show all") {
						$boards = Board::getBoards($_SESSION["id"]);
					}
					unset($_SESSION["logged"]);		
				} else {
					$boards = Board::getBoards($_SESSION["id"]);
				}
			}
			require_once("views/boards/home.php");
		}
		
		//simpelservice/boards/filterUser/x, x is hier niet optioneel
		public function filterUser() {
			$boards = Board::filterUser($_GET["id"]);
			require_once("views/boards/home.php");	
		}
	}
?>