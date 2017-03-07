<?php
	class Options {
		public $displayOptions;
		public $id;
		
		public function __construct($displayOptions, $id) {
			$this->displayOptions	= $displayOptions;
			$this->id				= $id;
		}
		
		public static function getOptions($id) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("SELECT * FROM options WHERE user_id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			$list[] = new Options($res["display_options"], $res["id"]);
			return $list;
		}
		
		public static function updateOptions($id, $displayOptions) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("UPDATE options SET display_options = :options WHERE id = :id");
			$req->execute(array('options' => $displayOptions, 'id' => $id));
		}
	}
?>