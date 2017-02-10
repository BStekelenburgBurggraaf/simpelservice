<?php
	class Board {
		public $boardName;
		public $ticketTitle 	= array();
		public $ticketContent 	= array();
		public $ticketAuthor 	= array();
		public $ticketPriority 	= array();
		
		public function __construct($boardName, $ticketTitle, $ticketContent, $ticketAuthor, $ticketPriority) {
			$this->boardName 		= $boardName;
			$this->ticketTitle 		= $ticketTitle;
			$this->ticketContent	= $ticketContent;
			$this->ticketAuthor 	= $ticketAuthor;
			$this->ticketPriority	= $ticketPriority;
		}
		
		public static function getBoards($id) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("SELECT bedrijf_id, status FROM users WHERE users.id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			$bedrijf_id = $res["bedrijf_id"];
			$status = $res["status"];
			if ($status == "personeel") {
				$req = $db->query("SELECT * FROM boards");
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
					
					$req3 = $db->prepare("SELECT username FROM users WHERE id = :id");
					$req3->execute(array('id' => $ticket["user_id"]));
					$res = $req3->fetch();
					
					array_push($ticketAuthor, $res["username"]);
				}
				
				$list[] = new Board($boardName, $ticketTitle, $ticketContent, $ticketPriority, $ticketAuthor);
			}
			return $list;
		}
	}
?>