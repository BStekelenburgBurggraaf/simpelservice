<?php
	class Admin {
		//Maak een project aan
		public static function createProject($title, $bedrijf, $category) {
			$db = Db::getInstance();
			
			$req = $db->prepare("INSERT INTO boards (title, bedrijf_id, category_id) VALUES (:title, :bedrijf, :category)");
			$req->execute(array('title' => $title, 'bedrijf' => $bedrijf, 'category' => $category));
		}
		
		//Maak een bedrijf aan
		public static function createCompany($naam) {
			$db = Db::getInstance();
			
			$req = $db->prepare("INSERT INTO bedrijf (naam) VALUES (:naam)");
			$req->execute(array('naam' => $naam));
		}
		
		//Maak een categorie aan
		public static function createCategory($naam) {
			$db = Db::getInstance();
			
			$req = $db->prepare("INSERT INTO categories (title) VALUES (:title)");
			$req->execute(array('title' => $naam));
		}
		
		//Maak een user aan
		public static function createUser($naam, $password, $email, $bedrijf, $role) {
			$db = Db::getInstance();
			
			$req = $db->prepare("INSERT INTO users (username, email, password, role, bedrijf_id) VALUES (:naam, :email, :password, :role, :bedrijf)");
			$req->execute(array('naam' => $naam, 'email' => $email, 'password' => $password, 'role' => $role, 'bedrijf' => $bedrijf));
		}
		
		//Haal categorieën op
		public static function getCategories() {
			$db = Db::getInstance();
			
			$req = $db->prepare("SELECT * FROM categories");
			$req->execute();
			foreach($req->fetchAll() as $row) {
				$list[] = array($row["id"], $row["title"]);
			}
			return $list;  	
		}
		
		//Haal bedrijven op
		public static function getCompanies() {
			$db = Db::getInstance();
			
			$req = $db->prepare("SELECT * FROM bedrijf");
			$req->execute();
			foreach($req->fetchAll() as $row) {
				$list[] = array($row["id"], $row["naam"]);	
			}
			return $list;
		}
		
		//Haal projecten op
		public static function getProjects() {
			$db = Db::getInstance();
			
			$req = $db->prepare("SELECT * FROM boards");
			$req->execute();
			foreach($req->fetchAll() as $row) {
				$req = $db->prepare("SELECT naam FROM bedrijf WHERE id = :id");
				$req->execute(array('id' => $row["bedrijf_id"]));
				$bedrijf = $req->fetch();
				
				$req = $db->prepare("SELECT title FROM categories WHERE id = :id");
				$req->execute(array('id' => $row["category_id"]));
				$category = $req->fetch();
				
				$list[] = array($row["id"], $row["title"], $bedrijf["naam"], $category["title"]);	
			}
			return $list;
		}
		
		//Haal gebruikers op
		public static function getUsers() {
			$db = Db::getInstance();
			
			$req = $db->prepare("SELECT * FROM users");	
			$req->execute();
			foreach($req->fetchAll() as $row) {
				$req = $db->prepare("SELECT naam FROM bedrijf WHERE id = :id");
				$req->execute(array('id' => $row["bedrijf_id"]));
				$bedrijf = $req->fetch();
				
				$list[] = array($row["id"], $row["username"], $row["email"], $row["role"], $bedrijf["naam"]);	
			}
			return $list;
		}
		
		//Haal de rol van de huidige gebruiker op
		public static function getRole($id) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("SELECT role FROM users WHERE id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			return $res["role"];
		}
	}
?>