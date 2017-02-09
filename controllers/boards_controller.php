<?php
	class BoardsController {
		public function home() {
			$boards = Board::getBoards($_SESSION["id"]);
			require_once("views/boards/home.php");
		}
	}
?>