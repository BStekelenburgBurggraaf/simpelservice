<?php
	class OptionsController {
		public function home() {
			if($_POST) {
				Options::updateOptions($_POST["id"], $_POST["displayOptions"]);	
			}
			$options = Options::getOptions($_SESSION["id"]);
			require_once("views/options/home.php");
		}
	}
?>