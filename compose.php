<?php 
	session_start(); 
  require "connection.php";
  
  $insert = $conn -> prepare("INSERT INTO Messages (recipient_ids, sender_id, subject, body, date_sent) VALUES (:recipient_ids, :sender_id, :subject, :body, :date_sent)");
  $insert -> bindParam(':recipient_ids', $recipient_ids);
  $insert -> bindParam(':sender_id', $sender_id);
  $insert -> bindParam(':subject', $subject);
  $insert -> bindParam(':body', $body);
  $insert -> bindParam(':date_sent', $date_sent);
  
  $recipErr = $subjectrErr = $msgErr = $noExist = $success = $recipient_ids = "";
  $recipValid = $subjectValid = $msgValid = false;
  $recipients = preg_replace('/\s+/', '', sanitize($_POST["recipients"]));
  $recipientsArray = explode(",", $recipients);
  $subj = sanitize($_POST["subject"]);
  $message = sanitize($_POST["message"]);
  $valid = true;
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  if (empty($subj)) {
	    $subjectrErr = "Subject is required";
	    $valid = false;
	  } else {
	    $valid = true;
	    $subjectrErr = "";
	    $subjectValid = true;
	  }
	  
	  if (empty($message)) {
	    $msgErr = "Message is required";
	    $valid = false;
	  } else {
	    $valid = true;
	    $msgErr = "";
	    $msgValid = true;
	  }
	  
	  if (empty($recipients)) {
	    $recipErr = "Recipient(s) required";
	    $valid = $recipValid = false;
	  } else {
	  	foreach($recipientsArray as $recip) {
  			$stmt = $conn->query("SELECT username FROM Users WHERE username='$recip'");
      	$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
      	
      	if (count($user) === 0) {
      		$noExist .= $recip . ", ";
      	}
	  	}
	  	if(!empty($noExist)) {
	  		$recipErr = "Recipient(s): $noExist doesn't exist";
		    $valid = $recipValid = false;
	  	} else {
		    $valid = $recipValid = true;
		    $recipErr = "";
	  	}
	  }
	  
	  if ($valid) {
	  	$length = count($recipientsArray) - 1;
	  	foreach($recipientsArray as $recip) {
  			$stmt = $conn->query("SELECT id FROM Users WHERE username='$recip'");
      	$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
      	$recipient_ids .= $user[0]["id"] . " ";
	  	}
	  	$sender = $_SESSION["user"];
			$stmt = $conn->query("SELECT id FROM Users WHERE username='$sender'");
    	$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    	
    	$recipient_ids = trim($recipient_ids);
    	$sender_id = $user[0]["id"];
	  	$subject = $subj;
	  	$body = $message;
	  	date_default_timezone_set("America/New_York");
	  	$date_sent = date("h:i A - M d, Y");
	  	$insert->execute();
	  	$success = "Message Sent!";
	  }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<title>Compose</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<script type="text/javascript" src="user.js"></script>
  </head>
  <body>
		<header>
		  <a href="<?php if ($_SESSION["user"] === "admin") {echo "admin.php";} else {echo "user.php";}?>">
		  <span id="logo">CheapoMail</span></a>
		  <a href="logout.php"><span class="right" id="logout">Logout</span></a>
		  <span class="right hello">Hello, <?php echo $_SESSION["user"]; ?> </span>
		</header>
		<section>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      	<span class="success"><?php echo $success; ?></span>
      	<h1>NEW MESSAGE</h1>
      	
	      <span class="error-text left"><?php echo $recipErr; ?></span>
	      <input class="<?php if (!empty($recipErr)) {echo "error";} elseif ($recipValid && empty($success)) {echo "valid";} else {echo "";} ?>" 
	      type="text" name="recipients" placeholder="To: (Separate usernames using commas ',' eg. abby, bob, joe)" value="<?php if (empty($success)) {echo $recipients;} ?>">
	      
	      <span class="error-text left"><?php echo $subjectrErr; ?></span>
				<input class="<?php if (!empty($subjectrErr)) {echo "error";} elseif ($subjectValid && empty($success)) {echo "valid";} else {echo "";} ?>" 
				type="text" name="subject" placeholder="Subject" value="<?php if (empty($success)) {echo $subj;} ?>">
				
	      <span class="error-text left"><?php echo $msgErr; ?></span>
				<input  class="<?php if (!empty($msgErr)) {echo "error";} elseif ($msgValid && empty($success)) {echo "valid";} else {echo "";} ?>"  
				type="textarea" name="message" placeholder="Message" value="<?php if (empty($success)) {echo $message;} ?>">
	      
	      <input type="submit" name="send" value="SEND MESSAGE" id="submit">
      </form>

		</section>
  </body>
</html>
