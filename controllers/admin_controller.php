<?php
	class AdminController {
		// /simpelservice/admin/home
		public function home() {
			$categoriesProjects = Admin::getCategories(1);
			$categoriesTickets 	= Admin::getCategories(0);
			$companies 	= Admin::getCompanies();
			$projects 	= Admin::getProjects();
			$users 		= Admin::getUsers();
			$role 		= Admin::getRole($_SESSION["id"]);
			
			//Check of de user admin is, anders stuur terug naar boards.
			if($role != "admin") {
				header("Location: /simpelservice/boards/home");	
			}
			
			require_once("views/admin/home.php");
		}
		
		// /simpelservice/admin/createProject
		public function createProject() {
			$role 		= Admin::getRole($_SESSION["id"]);
			
			//Check of de user admin is, anders stuur terug naar boards.
			if($role != "admin") {
				header("Location: /simpelservice/boards/home");	
			}
			
			//Als het form verstuurd is, maak het project aan en stuur dan terug naar /simpelservice/admin/home
			if ($_POST) {
				$project = Admin::createProject($_POST["title"], $_POST["bedrijf"], $_POST["category"]);
				header("Location: /simpelservice/admin/home");	
			}
			
			$categories = Admin::getCategories(1);
			$companies = Admin::getCompanies();
			
			require_once("views/admin/project.php");
		}
		
		// /simpelservice/admin/createCategory/{identifier}
		public function createCategory() {
			$role = Admin::getRole($_SESSION["id"]);
			
			//Check of de user admin is, anders stuur terug naar boards.
			if($role != "admin") {
				header("Location: /simpelservice/boards/home");	
			}
			
			//Als het form verstuurd is, maak de categorie aan en stuur dan terug naar /simpelservice/admin/home
			if ($_POST) {
				$category = Admin::createCategory($_POST["naam"], $_POST["type"]);
				header("Location: /simpelservice/admin/home");
			}
			
			require_once("views/admin/category.php");	
		}
		
		// /simpelservice/admin/createCompany
		public function createCompany() {
			$role 		= Admin::getRole($_SESSION["id"]);
			
			//Check of de user admin is, anders stuur terug naar boards.
			if($role != "admin") {
				header("Location: /simpelservice/boards/home");	
			}
			
			//Als het form verstuurd is, maak het bedrijf aan en stuur dan terug naar /simpelservice/admin/home
			if ($_POST) {
				$company = Admin::createCompany($_POST["name"]);
				header("Location: /simpelservice/admin/home");
			}
			
			require_once("views/admin/company.php");
		}
		
		// /simpelservice/admin/createUser
		public function createUser() {
			$role 		= Admin::getRole($_SESSION["id"]);
			
			//Check of de user admin is, anders stuur terug naar boards.
			if($role != "admin") {
				header("Location: /simpelservice/boards/home");	
			}
			
			//Als het form verstuurd is, maak de gebruiker aan en stuur dan terug naar /simpelservice/admin/home
			if ($_POST) {
				$user = Admin::createUser($_POST["naam"], $_POST["password"], $_POST["email"], $_POST["bedrijf"], $_POST["role"]);
				header("Location: /simpelservice/admin/home");	
			}
			
			$companies = Admin::getCompanies();
			
			require_once("views/admin/user.php");
		}
	}
?>