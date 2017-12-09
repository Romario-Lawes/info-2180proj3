<?php 
	session_start();
  require "connection.php";
  
	$stmt = $conn->query("SELECT * FROM Messages ORDER BY id DESC;");
	$msgs = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$currentUser = $_SESSION["user"];
	$stmt = $conn->query("SELECT * FROM Users WHERE username='$currentUser'");
	$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$userID = $user[0]["id"];
	
	$inboxMsgs = "";
	
	foreach ($msgs as $m) {
		$recipIDs = $m["recipient_ids"];
		$recipIDsArray = explode(" ", $recipIDs);
		
		$msgID = $m["id"];
		$senderID = $m["sender_id"];
		$stmt = $conn->query("SELECT * FROM Users WHERE id='$senderID'");
		$sender = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$stmt = $conn->query("SELECT * FROM Messages_read WHERE message_id='$msgID' AND reader_id='$userID';");
		$msgRead = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$new = "";
	
  	if (count($msgRead) === 0) { 
  		$new = " new";
  	} 
		
		if(in_array($user[0]["id"], $recipIDsArray)) {
			$inboxMsgs .= "<tr class='msgs $new' id='$msgID'>" . '<td>' . $sender[0]['username'] . '</td>' . '<td>' . $m['subject'] . '</td>' .
				  '<td>' . $m['date_sent'] . '</td>' . '</tr>';
		}
	}
?>