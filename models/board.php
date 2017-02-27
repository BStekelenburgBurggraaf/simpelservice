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
		
		public function __construct($boardName, $ticketTitle, $ticketContent, $ticketAuthor, $ticketPriority, $ticketCategory, $ticketStatus, $boardId) {
			$this->boardName 		= $boardName;
			$this->boardId			= $boardId;
			$this->ticketTitle 		= $ticketTitle;
			$this->ticketContent	= $ticketContent;
			$this->ticketAuthor 	= $ticketAuthor;
			$this->ticketPriority	= $ticketPriority;
			$this->ticketCategory	= $ticketCategory;
			$this->ticketStatus		= $ticketStatus;
		}
		
		public static function getBoards($id, $searchId = NULL) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("SELECT bedrijf_id, status FROM users WHERE users.id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			$bedrijf_id = $res["bedrijf_id"];
			$status = $res["status"];
			if ($status == "personeel") {
				if(!is_null($searchId)){
					$req = $db->prepare("SELECT * FROM boards WHERE bedrijf_id = :id");
					$req->execute(array('id' => $searchId));
				} else {
					$req = $db->query("SELECT * FROM boards");
				}
			} else {
				$req = $db->prepare("SELECT * FROM boards WHERE bedrijf_id = :id");
				$req->execute(array('id' => $bedrijf_id));	
			}
			foreach($req->fetchall() as $board) {
				$boardName = $board["title"];
				$boardId = $board["id"];
				$ticketTitle = array();
				$ticketContent = array();
				$ticketPriority = array();
				$ticketAuthor = array();
				$ticketCategory = array();
				$ticketStatus = array();
				if($status == "personeel") {
					$req2 = $db->prepare("SELECT * FROM tickets WHERE board_id = :id");
				} else {
					$req2 = $db->prepare("SELECT * FROM tickets WHERE board_id = :id AND visibility = 'zichtbaar'");	
				}
				$req2->execute(array('id' => $boardId));
				foreach($req2->fetchAll() as $ticket) {
					array_push($ticketTitle, $ticket["title"]);
					array_push($ticketContent, $ticket["description"]);
					array_push($ticketPriority, $ticket["priority"]);
					array_push($ticketCategory, $ticket["category"]);
					array_push($ticketStatus, $ticket["status"]);
					
					$req3 = $db->prepare("SELECT username FROM users WHERE id = :id");
					$req3->execute(array('id' => $ticket["user_id"]));
					$res = $req3->fetch();
					
					array_push($ticketAuthor, $res["username"]);
				}
				
				$list[] = new Board($boardName, $ticketTitle, $ticketContent, $ticketAuthor, $ticketPriority, $ticketCategory, $ticketStatus, $boardId);
			}
			return $list; 
		}
		
		public static function filterUser($id) {
			$db = Db::getInstance();
			
			$req = $db->prepare("SELECT bedrijf_id, status FROM users WHERE id = :id");
			$req->execute(array('id' => $_SESSION["id"]));
			$res = $req->fetch();
			$bedrijf_id = $res["bedrijf_id"];
			$status = $res["status"];
			
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
			if ($status == "personeel") {
				$req = $db->prepare("SELECT * FROM boards WHERE id IN ($boardsCount)");
				$req->execute($boards);
			} else {
				$req = $db->prepare("SELECT * FROM boards WHERE bedrijf_id = $bedrijf_id AND id IN ($boardsCount)");
				$req->execute($boards);
			}
			foreach($req->fetchall() as $board) {
				$boardName = $board["title"];
				$boardId = $board["id"];
				$ticketTitle = array();
				$ticketContent = array();
				$ticketPriority = array();
				$ticketAuthor = array();
				$ticketCategory = array();
				$ticketStatus = array();
				if($status == "personeel") {
					$req2 = $db->prepare("SELECT * FROM tickets WHERE board_id = $boardId AND id IN ($ticketsCount)");
				} else {
					$req2 = $db->prepare("SELECT * FROM tickets WHERE board_id = $boardId AND visibility = 'zichtbaar' AND id IN ($ticketsCount)");	
				}
				$req2->execute($tickets);
				foreach($req2->fetchAll() as $ticket) {
					array_push($ticketTitle, $ticket["title"]);
					array_push($ticketContent, $ticket["description"]);
					array_push($ticketPriority, $ticket["priority"]);
					array_push($ticketCategory, $ticket["category"]);
					array_push($ticketStatus, $ticket["status"]);
					
					$req3 = $db->prepare("SELECT username FROM users WHERE id = :id");
					$req3->execute(array('id' => $ticket["user_id"]));
					$res = $req3->fetch();
					
					array_push($ticketAuthor, $res["username"]);
				}
				
				$list[] = new Board($boardName, $ticketTitle, $ticketContent, $ticketAuthor, $ticketPriority, $ticketCategory, $ticketStatus, $boardId);
			}
			return $list;
		}
	}
?>