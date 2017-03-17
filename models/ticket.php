	<?php
	class Ticket {
		public $id;
		public $author;
		public $company;
		public $title;
		public $content;
		public $category;
		public $priority;
		public $zichtbaar;
		public $fileNames;
		public $status;
		
		public function __construct($id, $author, $company, $title, $content, $category, $priority, $zichtbaar, $fileNames, $status) {
			$this->id			= $id;
			$this->author		= $author;
			$this->company		= $company;
			$this->title		= $title;
			$this->content		= $content;
			$this->category		= $category;
			$this->priority 	= $priority;
			$this->zichtbaar 	= $zichtbaar;
			$this->fileNames 	= $fileNames;
			$this->status		= $status;
		}
		
		public static function uploadImages($files) {
			$file_count = count($files["images"]["name"]);
			$list = '';
			$target_dir = "uploads/";
			for ($i = 0; $i<$file_count; $i++) {
				$target_file = $target_dir . basename($files["images"]["name"][$i]);
				$uploadOk = 1;
				$j = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				// Check if image file is a actual image or fake image
				if(isset($_POST["submit"])) {
					$check = getimagesize($files["images"]["tmp_name"][$i]);
					if($check !== false) {
						echo "Dit bestand is een image - " . $check["mime"] . ".";
						$uploadOk = 1;
					} else {
						echo "Dit bestand is geen image.";
						$uploadOk = 0;
					}
				}
				// Check if file already exists
				while (file_exists($target_file)) {
					if ($j == 1) {
						$pos = strpos($target_file, $imageFileType);
						$target_file = substr_replace($target_file, "(" . $j . ")", ($pos -1), 0);
					} else {
						$pos = strpos($target_file, "(". ($j-1) . ")" );
						$pos2 = strpos($target_file, $imageFileType);
						$diff = $pos2 - $pos;
						$target_file = substr_replace($target_file, "(" . $j . ")", $pos, ($diff -1));
					}
					$j++;
				}
				// Check file size
				if ($files["images"]["size"][$i] > 500000) {
					echo "Het bestand is te groot.";
					$uploadOk = 0;
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
					echo "Alleen jpg, png, jpeg of gif bestanden zijn toegestaan.";
					$uploadOk = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "Er is iets fout gegaan, het bestand is niet geupload.";
				// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($files["images"]["tmp_name"][$i], $target_file)) {
						echo "Het bestand, ". basename( $_FILES["images"]["name"][$i]). ", is geupload.";
						$list .= $target_file . ",";
					} else {
						echo "Er is iets fout gegaan tijdens het uploaden.";
					}
				}
			}
			return $list;
		}
		
		public static function create($user_id, $title, $content, $category, $priority, $board_id, $visible, $fileNames) {
			$db = Db::getInstance();
			
			$id = intval($user_id);
			//Eerst het bedrijfsid uit het database ophalen
			$req = $db->prepare("SELECT bedrijf_id FROM users WHERE users.id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			$bedrijf_id = $res["bedrijf_id"];
			
			//Insert into
			$req = $db->prepare("INSERT INTO tickets (title, description, category_id,  priority, files, user_id, bedrijf_id, board_id, visibility)
								 VALUES (:title, :description, :category, :priority, :fileNames, :user_id, :bedrijf_id, :board_id, :visibility)");
			$req->execute(array('title' => $title, 'description' => $content, 'category' => $category, 'priority' => $priority, 'fileNames' => $fileNames, 'user_id' => $user_id, 'bedrijf_id' => $bedrijf_id, 'board_id' => $board_id, 'visibility' => $visible ));
			$ticketId = $db->lastInsertId();
			
			$req = $db->prepare("SELECT * FROM users WHERE id = 1");
			$req->execute();
			$res = $req->fetch();
			$tickets = $res["ticket_subscriptions"] . " " . $ticketId . ",";
			
			$req = $db->prepare("UPDATE users SET ticket_subscriptions = :tickets WHERE id = 1");
			$req->execute(array('tickets' => $tickets));
			
			//Variabele word direct in de code gezet hier, omdat de parameter niet goed kon worden gebind in de execute.
			$req2 = $db->prepare("SELECT email FROM users WHERE role = 'personeel' AND board_subscriptions LIKE '% $board_id,%'");
			$req2->execute();
			//Naam van het board ophalen
			$req3 = $db->prepare("SELECT title FROM boards WHERE id = :id");
			$req3->execute(array('id' => $board_id));
			$board = $req3->fetch();
			$boardName = $board["title"];
			//Teller zodat alleen de eerste geen comma zal bevatten.
			$i = 0;
			$to = "";
			foreach($req2->fetchAll() as $user) {
				if ($i == 0) {
					$to = $user["email"];
					$i = 1;
				} else { 
					$to .= ", " . $user["email"];
				}
			}
			$subject = "New ticket: " . $title;
			$message = '
			<html>
			<head>
			  <title>New ticket: '.$title.'</title>
			</html>
			<body>
			  <h3>'. $title .'</h3>
			  <hr>
			  <p><b>Prioriteit:</b> '.$priority.'</p>
			  <p><b>Board:</b> '.$boardName.'</p>
			  <p><b>Content:</b><br/>'.$content.'
			</body>
			';
			
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=iso-8859-1';
			$headers[] = 'From: SimpelService <b.stekelenburg@burggraaf.nl>';
			
			//mail($to, $subject, $message, implode("\r\n", $headers));
		}
		
		public static function getTicket($id) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("SELECT * FROM tickets WHERE id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			$req = $db->prepare("SELECT * FROM users WHERE id = :id");
			$req->execute(array('id' => $res["user_id"]));
			$user = $req->fetch();
			$userName = $user["username"];
			
			$req = $db->prepare("SELECT * FROM bedrijf WHERE id = :id");
			$req->execute(array('id' => $res["bedrijf_id"]));
			$bedrijf = $req->fetch();
			$bedrijfsNaam = $bedrijf["naam"];
			
			$list[] = array($res["id"], $userName, $bedrijfsNaam, $res["title"], $res["description"], $res["category_id"], $res["priority"], $res["visibility"], $res["files"], $res["status"]);
			return $list;
		}
		
		public static function updateTicket($id, $status) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("UPDATE tickets SET status = :status WHERE id = :id");
			$req->execute(array('status' => $status, 'id' => $id));
			
			if($status == "closed") {
				//Variabele word direct in de code gezet hier, omdat de parameter niet goed kon worden gebind in de execute.
				$req2 = $db->prepare("SELECT email FROM users WHERE ticket_subscriptions LIKE '% $id,%'");
				$req2->execute();
				//Haal gegevens van ticket op
				$req3 = $db->prepare("SELECT * FROM tickets WHERE id = :id");
				$req3->execute(array('id' => $id));
				$res = $req3->fetch();
				//Teller zodat alleen de eerste geen comma zal bevatten.
				$i = 0;
				$to = "";
				foreach($req2->fetchAll() as $user) {
					if ($i == 0) {
						$to = $user["email"];
						$i = 1;
					} else { 
						$to .= ", " . $user["email"];
					}
				}
				
				$subject = "Ticket gesloten: " . $res["title"];
				$message = '
				<html>
				<head>
				  <title>New ticket: '.$res["title"].'</title>
				</html>
				<body>
				  <h3>'. $res["title"] .'</h3>
				  <hr>
				  <p><b>Content:</b><br/>'.$res["description"].'</br>
				  <p><b>Status:</b><br/>'.$res["status"].'</br>
				</body>
				';
				
				$headers[] = 'MIME-Version: 1.0';
				$headers[] = 'Content-type: text/html; charset=iso-8859-1';
				$headers[] = 'From: SimpelService <b.stekelenburg@burggraaf.nl>';
				
				//mail($to, $subject, $message, implode("\r\n", $headers));
			}
		}
		
		public static function show($id) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("SELECT * FROM tickets WHERE id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			$req = $db->prepare("SELECT * FROM bedrijf WHERE id = :id");
			$req->execute(array('id' => $res["bedrijf_id"]));
			$company = $req->fetch();
			
			$req = $db->prepare("SELECT * FROM categories WHERE id = :id");
			$req->execute(array('id' => $res["category_id"]));
			$category = $req->fetch();
			
			$req = $db->prepare("SELECT * FROM users WHERE id = :id");
			$req->execute(array('id' => $res["user_id"]));
			$author = $req->fetch();
			
			$list = new Ticket($id, $company["naam"], $author["username"], $res["title"], $res["description"], $category["title"], $res["priority"], $res["visibility"], $res["files"], $res["status"]);
			return $list;	
		}
			
		public static function GetUserType($id) {
			$db = Db::getInstance();
			
			$id = intval($id);
			$req = $db->prepare("SELECT role FROM users WHERE id = :id");
			$req->execute(array('id' => $id));
			$res = $req->fetch();
			
			return $res["role"];	
		}
		
		public static function getCategories() {
			$db = Db::getInstance();
			
			$req = $db->prepare("SELECT * FROM categories WHERE type = 0");
			$req->execute();
			foreach($req->fetchAll() as $row) {
				$list[] = array($row["id"], $row["title"]);
			}
			return $list;
		}
		
		public static function getSubscribedUsers($id){
			$db = Db::getInstance();
			
			$id = intval($id);
			$list = array();
			$req = $db->prepare("SELECT * FROM users WHERE ticket_subscriptions LIKE '% $id,%'");
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
	}
?>	