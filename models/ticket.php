<?php
	class Ticket {
		public $id;
		public $author;
		public $company;
		public $title;
		public $content;
		public $category;
		public $priority;
		
		public function __construct($id, $author, $company, $title, $category, $content) {
			$this->id		= $id;
			$this->author	= $author;
			$this->company	= $author;
			$this->title	= $title;
			$this->content	= $content;
			$this->category	= $category;
			$this->priority = $priority;
		}
		
		public static function create($user_id, $title, $content, $category, $priority, $board_id) {
			$db = Db::getInstance();
			
			$id = intval($user_id);
			//Eerst het bedrijfsid uit het database ophalen
			$req = $db->prepare("SELECT bedrijf_id FROM users WHERE users.id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			$bedrijf_id = $res["bedrijf_id"];
			
			//Insert into
			$req = $db->prepare("INSERT INTO tickets (title, description, category,  priority, user_id, bedrijf_id, board_id) 
								 VALUES (:title, :description, :category, :priority, :user_id, :bedrijf_id, :board_id)");
			$req->execute(array('title' => $title, 'description' => $content, 'category' => $category, 'priority' => $priority, 'user_id' => $user_id, 'bedrijf_id' => $bedrijf_id, 'board_id' => $board_id ));
		}
	}
?>