<?php
	class LoginController {
		public function login() {
			if($_POST) {
				//Voer getLogin uit die in het login model staat
				$login = Login::getLogin($_POST['uname'], $_POST['psw']);
				if($login[0] == "gelukt"){
					$_SESSION["id"] = $login[1];
					$_SESSION["log"] = "ja";
					//header("Location: https://www.google.com");
				}
				$uname = $_POST["uname"];
			}
			require_once("views/login/login.php");
		}
	}
?>