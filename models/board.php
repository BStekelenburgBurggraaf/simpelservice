<?php
	class Board {
		public $boardName;
		public $boardId;
		public $ticketTitle 	= array();
		public $ticketContent 	= array();
		public $ticketAuthor 	= array();
		public $ticketPriority 	= array();
		public $ticketCategory	= array();
		public $ticketStatus	= array();
		public $ticketUserId	= array();
		public $ticketId		= array();
		
		public function __construct($boardName, $ticketTitle, $ticketContent, $ticketAuthor, $ticketPriority, $ticketCategory, $ticketStatus, $boardId, $ticketUserId, $ticketId) {
			$this->boardName 		= $boardName;
			$this->boardId			= $boardId;
			$this->ticketTitle 		= $ticketTitle;
			$this->ticketContent	= $ticketContent;
			$this->ticketAuthor 	= $ticketAuthor;
			$this->ticketPriority	= $ticketPriority;
			$this->ticketCategory	= $ticketCategory;
			$this->ticketStatus		= $ticketStatus;
			$this->ticketUserId		= $ticketUserId;
			$this->ticketId			= $ticketId;
		}
		
		//Haal de projecten op, id moet geset zijn, searchId hoeft niet persé, dit is voor specifieke projecten
		public static function getBoards($id, $searchId = NULL) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("SELECT bedrijf_id, role FROM users WHERE users.id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			$bedrijf_id = $res["bedrijf_id"];
			$status = $res["role"];
			if ($status == "personeel" || $status == "admin") {
				if(!is_null($searchId)){
					$req = $db->prepare("SELECT * FROM boards WHERE id = :id");
					$req->execute(array('id' => $searchId));
				} else {
					$req = $db->query("SELECT * FROM boards");
				}
			} else {
				$req = $db->prepare("SELECT * FROM boards WHERE id = :id");
				$req->execute(array('id' => $bedrijf_id));	
			}
			foreach($req->fetchall() as $board) {
				$boardName 		= $board["title"];
				$boardId 		= $board["id"];
				$ticketTitle 	= array();
				$ticketContent 	= array();
				$ticketPriority = array();
				$ticketAuthor 	= array();
				$ticketCategory = array();
				$ticketStatus 	= array();
				$ticketUserId	= array();
				$ticketId		= array();
				if($status == "personeel") {
					$req2 = $db->prepare("SELECT * FROM tickets WHERE board_id = :id AND visibility != 'onzichtbaar'");
				} elseif($status == "admin") {
					$req2 = $db->prepare("SELECT * FROM tickets WHERE board_id = :id");
				}else {
					$req2 = $db->prepare("SELECT * FROM tickets WHERE board_id = :id AND visibility = 'zichtbaar'");	
				}
				$req2->execute(array('id' => $boardId));
				foreach($req2->fetchAll() as $ticket) {
					array_push($ticketTitle, $ticket["title"]);
					array_push($ticketContent, $ticket["description"]);
					array_push($ticketPriority, $ticket["priority"]);
					array_push($ticketCategory, $ticket["category_id"]);
					array_push($ticketStatus, $ticket["status"]);
					array_push($ticketUserId, $ticket["user_id"]);
					array_push($ticketId, $ticket["id"]);
					
					$req3 = $db->prepare("SELECT username FROM users WHERE id = :id");
					$req3->execute(array('id' => $ticket["user_id"]));
					$res = $req3->fetch();
					
					array_push($ticketAuthor, $res["username"]);
				}
				
				$list[] = new Board($boardName, $ticketTitle, $ticketContent, $ticketAuthor, $ticketPriority, $ticketCategory, $ticketStatus, $boardId, $ticketUserId, $ticketId);
			}
			return $list; 
		}
		
		//Filter projecten en tickets op een user, zo zie je alleen de tickets en projecten waar deze user bij is aangemeld, en je zelf kan zien. Voorbeeld: User van bedrijf B kan van personeel van Burggraaf It niet projecten van bedrijf A zien als deze op het personeel filtert.
		public static function filterUser($id) {
			$db = Db::getInstance();
			
			$req = $db->prepare("SELECT bedrijf_id, role FROM users WHERE id = :id");
			$req->execute(array('id' => $_SESSION["id"]));
			$res = $req->fetch();
			$bedrijf_id = $res["bedrijf_id"];
			$status = $res["role"];
			
			$id = intval($id);
			$req = $db->prepare("SELECT * FROM users WHERE id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			$boards = $res["board_subscriptions"];
			$tickets = $res["ticket_subscriptions"];
			//Trimmen van de lists, omdat er aan het einde een , staat.
			$boards = rtrim($boards, ",");
			$tickets = rtrim($tickets, ",");
			//remappen van de arrays zodat het goed kan worden ingevoerd
			$boards = explode(", ", $boards);
			$boardsCount = str_repeat("?, ", count($boards) - 1) . "?";
			$tickets = explode(", ", $tickets);
			$ticketsCount = str_repeat("?, ", count($tickets) -1) . "?";
			
			//Variabele worden hier in de query gezet omdat PDO niet goed kan omgaan met arrays en de IN command, dus word deze als volgt opgelost.
			if ($status == "personeel" || $status == "admin") {
				$req = $db->prepare("SELECT * FROM boards WHERE id IN ($boardsCount)");
				$req->execute($boards);
			} else {
				$req = $db->prepare("SELECT * FROM boards WHERE bedrijf_id = $bedrijf_id AND id IN ($boardsCount)");
				$req->execute($boards);
			}
			foreach($req->fetchall() as $board) {
				$boardName = $board["title"];
				$boardId = $board["id"];
				//set arrays voor individuele tickets
				$ticketTitle	= array();
				$ticketContent	= array();
				$ticketPriority = array();
				$ticketAuthor 	= array();
				$ticketCategory = array();
				$ticketStatus 	= array();
				$ticketUserId	= array();
				$ticketId		= array();
				//Herhaald, PDO kan niet goed omgaan met arrays in SQL IN ()
				if($status == "personeel") {
					$req2 = $db->prepare("SELECT * FROM tickets WHERE board_id = $boardId AND visibility != 'onzichtbaar' AND id IN ($ticketsCount)");
				} elseif($status == "personeel") {
					$req2 = $db->prepare("SELECT * FROM tickets WHERE board_id = $boardId AND id IN ($ticketsCount)");
				}else {
					$req2 = $db->prepare("SELECT * FROM tickets WHERE board_id = $boardId AND visibility = 'zichtbaar' AND id IN ($ticketsCount)");	
				}
				$req2->execute($tickets);
				foreach($req2->fetchAll() as $ticket) {
					array_push($ticketTitle, $ticket["title"]);
					array_push($ticketContent, $ticket["description"]);
					array_push($ticketPriority, $ticket["priority"]);
					array_push($ticketCategory, $ticket["category_id"]);
					array_push($ticketStatus, $ticket["status"]);
					array_push($ticketUserId, $ticket["user_id"]);
					array_push($ticketId, $ticket["id"]);
					
					$req3 = $db->prepare("SELECT username FROM users WHERE id = :id");
					$req3->execute(array('id' => $ticket["user_id"]));
					$res = $req3->fetch();
					
					array_push($ticketAuthor, $res["username"]);
				}
				
				$list[] = new Board($boardName, $ticketTitle, $ticketContent, $ticketAuthor, $ticketPriority, $ticketCategory, $ticketStatus, $boardId, $ticketUserId, $ticketId);
			}
			return $list;
		}
		
		//Haal het login type op, dit word alleen gebruikt direct na het inloggen
		public static function getLoginType($id) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("SELECT * FROM options WHERE user_id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			return $res["display_options"];
		}
		
		//Haal op welk type user het is
		public static function getUserType($id) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("SELECT role FROM users WHERE id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			return $res["role"];	
		}
		
		//Haal alle subscribed users op bij een project
		public static function getSubscribedUsers($id){
			$db = Db::getInstance();
			
			$id = intval($id);
			$list = array();
			//Het ID meegeven als :id en dan binden werkte hier neit, dus heb ik gekozen om de variabele gewoon in de query te zetten
			$req = $db->prepare("SELECT * FROM users WHERE board_subscriptions LIKE '% $id,%'");
			$req->execute();
			foreach($req->fetchAll() as $user) {
				$userId = $user["id"];
				$username = $user["username"];
				$userRole = $user["role"];
				
				$req = $db->prepare("SELECT * FROM bedrijf WHERE id = :id");
				$req->execute(array('id' => $user["bedrijf_id"]));
				$bedrijf = $req->fetch();
				
				$userBedrijf = $bedrijf["naam"];
				$list[] = array($userId, $username, $userBedrijf, $userRole);
			}
			return $list;
		}
		
		public static function getBoardCompany($id) {
			$db = Db::getInstance();
			
			$id = intval($id);
			
			$req = $db->prepare("SELECT bedrijf_id FROM boards WHERE id = :id");	
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			return $res;
		}
		
		public static function getEmployees($id) {
			$db = Db::getInstance();
			
			$id = intval($id);
			if($id == 1) {
				$req = $db->prepare("SELECT * FROM users WHERE bedrijf_id = :id");
			} else {
				$req = $db->prepare("SELECT * FROM users WHERE bedrijf_id = :id OR bedrijf_id = 1");	
			}
			$req->execute(array('id' => $id));
			foreach($req->fetchAll() as $user) {
				$req = $db->prepare("SELECT * FROM bedrijf WHERE id = :id");
				$req->execute(array('id' => $user["bedrijf_id"]));
				$res = $req->fetch();
				
				$list[] = array($user["id"], $user["username"], $user["role"], $res["naam"], $user["board_subscriptions"]);
			}
			return $list;
		}
		
		//Het updaten van de aangemelde users bij een ticket
		public static function updateSubscribers($id, $check) {
			$db = Db::getInstance();
			for($i = 0; $i < count($id); $i++) {
				$req = $db->prepare("SELECT board_subscriptions FROM users WHERE id = :id");
				$req->execute(array('id' => $id[$i]));
				$res = $req->fetch();
				$subscriptions = $res["board_subscriptions"];
				$ticketId = " ".$_GET["id"].",";
				if($check[$i] == "false"){
					if(strpos($subscriptions, $ticketId) !== false) {
						$subscriptions = str_replace($ticketId, "", $subscriptions);
						$req = $db->prepare("UPDATE users SET board_subscriptions = :subscriptions WHERE id = :id");
						$req->execute(array('subscriptions' => $subscriptions, 'id' => $id[$i]));
					}
				} elseif($check[$i] == "true") {
					if(strpos($subscriptions, $ticketId) === false) {
						$subscriptions = $subscriptions	. $ticketId;
						$req = $db->prepare("UPDATE users SET board_subscriptions = :subscriptions WHERE id = :id");
						$req->execute(array('subscriptions' => $subscriptions, 'id' => $id[$i]));
					}
				}
			}
		}
	}
?>