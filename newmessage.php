<!DOCTYPE html>
<html lang="en">
  <head>
    <title>CheapoMail - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script type="text/javascript" src="admin.js"></script>
  </head>
  <body>
    <header>
      <span id="logo">CheapoMail</span>
      <a href= "index.php"><span class="right" id="logout">Logout</span></a>
      <span class="right hello">Hello, admin</span>
    </header>
    <section>
			<form action = "newmessage.php" method="post">
				<h1 class="new">Compose and send a Message</h1>
				<input type="text" name="recipients" id="recipients" placeholder="Please use commas (,) to separate Recipients."><br/>
				<input type="text" name="subject" id="subject" placeholder="Subject"><br/>
				<input type="text" name="body" id="body" placeholder="Type message here"><br/>
				<input type="button" value="Send Messade" id="submit"/>
			</form>
    </section>
  </body>
</html>

<?php
  $host = getenv('IP');
  $username = getenv('C9_USER');
  $password = '';
  $dbname = 'cheapomail';
  
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	$current_users= "SELECT username FROM Users";
	
	$subject = $_POST(['subject']);
	$message = $_POST(['body']);
	$recipients= explode(",", $_POST['recipients']);
	
	if (!isset($subject)) {
		echo "subject not set";
		
	}
	if (!isset($message)) {
		echo "message field is empty";
		
	}
	if (isset($recipients)){
		
		for($i = 0; $i <= sizeof($recipients); $i++) {
			
			$current_recipient= $recipient[i];
			
			if(in_array($current_recipient, $current_users)){
				
				$recipient_id= "SELECT id FROM Users WHERE username= $current_recipient";
				
				$query= "UPDATE Messages SET body= $message, subject= $subject WHERE id= $recipient_id";
			}
		}
	}
	
	$conn= null;
?>