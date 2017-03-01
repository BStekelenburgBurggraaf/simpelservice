<?php
	class AdminController {
		public function home() {
			$categories = Admin::getCategories();
			$companies 	= Admin::getCompanies();
			$projects 	= Admin::getProjects();
			$users 		= Admin::getUsers();
			
			require_once("views/admin/home.php");
		}
		
		public function createProject() {
			if ($_POST) {
				$project = Admin::createProject($_POST["title"], $_POST["bedrijf"], $_POST["category"]);
				header("Location: /simpelservice/admin/home");	
			}
			
			$categories = Admin::getCategories();
			$companies = Admin::getCompanies();
			
			require_once("views/admin/project.php");
		}
		
		public function createCategory() {
			if ($_POST) {
				$category = Admin::createCategory($_POST["naam"]);
				header("Location: /simpelservice/admin/home");
			}
			
			require_once("views/admin/category.php");	
		}
		
		public function createCompany() {
			if ($_POST) {
				$company = Admin::createCompany($_POST["name"]);
				header("Location: /simpelservice/admin/home");
			}
			
			require_once("views/admin/company.php");
		}
		
		public function createUser() {
			if ($_POST) {
				$user = Admin::createUser($_POST["naam"], $_POST["password"], $_POST["email"], $_POST["bedrijf"], $_POST["role"]);
				header("Location: /simpelservice/admin/home");	
			}
			
			$companies = Admin::getCompanies();
			
			require_once("views/admin/user.php");
		}
	}
?>