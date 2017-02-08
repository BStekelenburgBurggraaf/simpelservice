<?php
	class Ticket {
		public $id;
		public $author;
		public $company;
		public $title;
		public $content;
		public $priority;
		
		public function __construct($id, $author, $company, $title, $content) {
			$this->id		= $id;
			$this->author	= $author;
			$this->company	= $author;
			$this->title	= $title;
			$this->content	= $content;
			$this->priority = $priority;
		}
		
		public function create($user_id, $title, $content, $priority) {
			$db = Db::getInstance();
			
			$id = intval($user_id);
			//Eerst het bedrijfsid uit het database ophalen
			$req = $db->prepare("SELECT bedrijf_id FROM users WHERE users.id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			$bedrijf_id = $res["bedrijf_id"];
			
			//Insert into
			$req = $db->prepare("INSERT INTO tickets (title, description,  priority, user_id, bedrijf_id) 
								 VALUES (:title, :description, :priority, :user_id, :bedrijf_id)");
			$req->execute(array('title' => $title, 'description' => $content, 'priority' => $priority, 'user_id' => $user_id, 'bedrijf_id' => $bedrijf_id));
		}
	}
?>