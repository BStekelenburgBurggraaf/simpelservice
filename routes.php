<?php
	function call($controller, $action) {
		//Maak het bestand dat dezelfde naam als de controller heeft required.
		require_once("controllers/" . $controller . "_controller.php");	
		
		//Maak een nieuwe instance van de benodigde controller.
		switch($controller) {
			case 'login':
				require_once("models/login.php");
				$controller = new LoginController();
			break;
			case 'boards':
				require_once("models/board.php");
				$controller = new BoardsController();
			break;
			case 'tickets':
				require_once("models/ticket.php");
				$controller = new TicketsController();
			break;
			
			case 'errors':
				$controller = new ErrorsController();
			break;
		}
		
		//Roep de actie aan
		$controller->{ $action }();
	}
	
	//Lijst van controller en acties
	$controllers = array('login' 	=> array('login', 'logout'),
						 'boards' 	=> array('home'),
						 'tickets' 	=> array('create', 'show'),
						 'errors' 	=> array('error'));
	
	//Check of de aangeroepen controller en acties bestaan
	if (array_key_exists($controller, $controllers)) {
		if (in_array($action, $controllers[$controller])) {
			call($controller, $action);
		} else {
			call('errors', 'error');	
		}
	} else {
		call('errors', 'error');	
	}
?>