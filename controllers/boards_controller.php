<?php
	class BoardsController {
		public function home() {
			if($_GET["id"] != '') {
				$boards = Board::getBoards($_SESSION["id"], $_GET["id"]);	
			} else {
				$boards = Board::getBoards($_SESSION["id"]);
			}
			require_once("views/boards/home.php");
		}
	}
?>