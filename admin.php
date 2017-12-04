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
      <a href="adduser.php"><input type="button" name="add_user" value="ADD USER"/></a>
      <a href="newmessage.php"><input type="button" name="compose_message" value="COMPOSE MESSAGE"/></a>
    </section>
  </body>
</html>

<?php
  $host = getenv('IP');
  $username = getenv('C9_USER');
  $password = '';
  $dbname = 'cheapomail';
  
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

  $insert = $conn -> prepare("INSERT INTO Users (firstname, lastname, username, password) VALUES (:firstname, :lastname, :username, :password)");
  $insert -> bindParam(':firstname', $firstname);
  $insert -> bindParam(':lastname', $lastname);
  $insert -> bindParam(':username', $user);
  $insert -> bindParam(':password', $pass);
  
	$fname = htmlentities($_POST['firstname']);
	$lname = htmlentities($_POST['lastname']);
	$uname = htmlentities($_POST['username']);
	$pword = htmlentities($_POST['password']);
	$pwordConfirm = htmlentities($_POST['passwordConfirm']);
	
	$passReg = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
	
	if (preg_match($passReg, $pword) &&  $pword === $pwordConfirm && !empty($fname) && !empty($lname) && !empty($uname)) {
		$firstname = $fname;
		$lastname = $lname;
		$user = $uname;
		$pass = password_hash($pword, PASSWORD_DEFAULT);
		$insert->execute();
		echo "Successfully Created New User: $uname";
	} else {
		echo "Failed to create new user. Please try again.";
	}
  
  // echo "Admin Page";
  
  // $firstname = "Mr";
  // $lastname = "Administrator";
  // $user = "admin";
  // $pass = md5("password123");
  // $insert -> execute();
  
  

  // $username = $_POST["username"];
  // $password = $_POST["password"];
  
  // //Check is user name and password is set
  // if ((!isset($username)) || (!isset($password))) {
  //     echo 'Username and password not set';
  // } else {
  //   $checkUpperCase = preg_match('/[A-Z]/', $password);
	 // $checkDigit = preg_match('/\d/', $password);
	 // $checklength = (strlen($password)>=8);
	  
	 // //Checking that password is valid.
	 // if(!$checkUpperCase || !$checkDigit || !$checklength){ 
	 //     echo 'Invalid password';
	 // } else {
	 //     //Code to add information to database;
	 //     //header("Location: adduser.php"); Redirects browser. File not yet created.
	 // }
  // }
?>