<?php 
	session_start();
  require "connection.php";
  
  $msgID = $_GET["id"];
	$stmt = $conn->query("SELECT * FROM Messages WHERE id='$msgID';");
	$msgs = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$senderID = $msgs[0]["sender_id"];
	$stmt = $conn->query("SELECT firstname, lastname, username FROM Users WHERE id='$senderID';");
	$sender = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$readerUsername = $_SESSION["user"];
	$stmt = $conn->query("SELECT id FROM Users WHERE username='$readerUsername';");
	$reader = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$readerID = $reader[0]["id"];
	
  $insert = $conn -> prepare("INSERT INTO Messages_read (message_id, reader_id, date_read) VALUES (:message_id, :reader_id, :date_read)");
  $insert -> bindParam(':message_id', $message_id);
  $insert -> bindParam(':reader_id', $reader_id);
  $insert -> bindParam(':date_read', $date_read);
  
	$stmt = $conn->query("SELECT * FROM Messages_read WHERE message_id='$msgID' AND reader_id='$readerID';");
	$readCheck = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
  if (count($readCheck) === 0) {
	  $reader_id = $readerID;
	  $message_id = $msgID;
		date_default_timezone_set("America/New_York");
		$date_read = date("h:i A - M d, Y");
	  $insert -> execute();
  }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Inbox - <?php echo $_SESSION["user"]; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<header>
			<a href= "<?php if ($_SESSION["user"] === "admin") {echo "admin.php";} else {echo "user.php";}?>">
			<span id="logo">CheapoMail</span></a>
			<a href= "logout.php"><span class="right" id="logout">Logout</span></a>
			<span class="right hello">Hello, <?php echo $_SESSION["user"]; ?> </span>
		</header>
		<section>
			<div class="message">
				<a href="<?php if ($_SESSION["user"] === "admin") {echo "admin.php";} else {echo "user.php";}?>">
				<input type="button" name="inbox" value="BACK TO INBOX"/></a>
				<div><?php echo $msgs[0]["date_sent"] ?></div>
				<div><?php echo $sender[0]["firstname"] . " " . $sender[0]["lastname"] . " (" . $sender[0]["username"] . ")" ?></div>
				<div><?php echo '"' . $msgs[0]["subject"] . '"' ?></div>
				<div class="align-left" id="body"><?php echo $msgs[0]["body"] ?></div>
			</div>
		</section>
	</body>
</html>