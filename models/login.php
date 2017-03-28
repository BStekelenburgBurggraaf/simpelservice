<?php
	class Login {
		//De post van de login
		public static function getLogin($username, $password){
			if($username != '' && $password != '')
			{
				$db = Db::getInstance();
				$req = $db->prepare("SELECT * FROM users WHERE username = :uname");
				$req->execute(array('uname' => $username));
				$result = $req->fetch();
				if($password == $result["password"]){
					return array("gelukt", $result["id"]);
				}
			}
			return "mislukt";
		}
	}
?>