<?php
	class Db {
		private static $instance = NULL;
		
		//construct en clone zijn private zodat niemand ze kan aanroepen.
		private function __construct() {}
		
		private function __clone() {}
		
		public static function getInstance() {
			if(!isset(self::$instance)) {
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        		self::$instance = new PDO('mysql:host=localhost;dbname=simpelservice', 'root', '', $pdo_options);
			}
			return self::$instance;
		}
	}
?>