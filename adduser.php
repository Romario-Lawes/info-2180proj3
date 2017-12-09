<?php
	session_start();
  require "connection.php";

  $insert = $conn -> prepare("INSERT INTO Users (firstname, lastname, username, password) VALUES (:firstname, :lastname, :username, :password)");
  $insert -> bindParam(':firstname', $firstname);
  $insert -> bindParam(':lastname', $lastname);
  $insert -> bindParam(':username', $user);
  $insert -> bindParam(':password', $pass);
  
	$fname = sanitize($_POST['firstname']);
	$lname = sanitize($_POST['lastname']);
	$uname = sanitize(strtolower($_POST['username']));
	$pword = sanitize($_POST['password']);
	$pwordConfirm = sanitize($_POST['passwordConfirm']);
	$passReg = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
	$unameReg = "/^[^\s]*$/";
	
	$valid = true;
  $fnameValid = $lnameValid = $userValid = $passValid = false;
  $fnameErr = $lnameErr = $userErr = $passErr = $success = "";
	
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    if (empty($fname)) {
      $fnameErr = "First Name is required";
      $valid = false;
    } else {
      $valid = true;
      $fnameErr = "";
      $fnameValid = true;
    }
    
    if (empty($lname)) {
      $lnameErr = "Last Name is required";
      $valid = false;
    } else {
      $valid = true;
      $lnameErr = "";
      $lnameValid = true;
    }
    
    if (empty($uname)) {
      $userErr = "Username is required";
      $valid = false;
    } elseif (!preg_match($unameReg, $uname)) {
      $userErr = "Username cannot contain spaces";
      $valid = false;
    } else {
      $valid = true;
      $userErr = "";
      $userValid = true;
    }
    
    if (empty($pword) || empty($pwordConfirm)) {
      $passErr = "Password & password confirmation is required";
      $valid = false;
    } else {
      if ($uname === "admin") {
        $valid = true;
        $passErr = "";
      } elseif (!preg_match($passReg, $pword) || !preg_match($passReg, $pwordConfirm)) {
        $passErr = "Minimum length: 8 characters. Must contain atleast one digit and one uppercase letter";
        $valid = false;
      } elseif ($pword !== $pwordConfirm) {
        $passErr = "Password and password confirmation don't match";
        $valid = false;
      }
    }
      
		if ($valid) {
      $stmt = $conn->query("SELECT username FROM Users WHERE username='$uname'");
      $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      if (count($user) > 0) {
      	$userErr = "User '$uname' already exists. Please choose another username";
      } else {
				$firstname = $fname;
				$lastname = $lname;
				$user = $uname;
				$pass = password_hash($pword, PASSWORD_DEFAULT);
				$insert->execute();
				$success = "Successfully created new user: $uname";
      }
		} 
		
	}
?>

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
      <a href= "admin.php"><span id="logo">CheapoMail</span></a>
      <a href= "logout.php"><span class="right" id="logout">Logout</span></a>
      <span class="right hello">Hello, <?php echo $_SESSION["user"]; ?> </span>
    </header>
    <section>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<span class="success"><?php echo $success; ?></span>
				
				<h1 class="new">Create New User</h1>
				
				<span class="error-text left"><?php echo $fnameErr; ?></span>
				<input class="<?php if (!empty($fnameErr)) {echo "error";} elseif ($fnameValid && empty($success)) {echo "valid";} else {echo "";} ?>"
				type="text" name="firstname" placeholder="First Name" value="<?php if (empty($success)) {echo $fname;} ?>"><br/>
				
				<span class="error-text left"><?php echo $lnameErr; ?></span>
				<input class="<?php if (!empty($lnameErr)) {echo "error";} elseif ($lnameValid && empty($success)) {echo "valid";} else {echo "";} ?>"
				type="text" name="lastname" placeholder="Last Name" value="<?php if (empty($success)) {echo $lname;} ?>"><br/>
				
				<span class="error-text left"><?php echo $userErr; ?></span>
				<input class="<?php if (!empty($userErr)) {echo "error";} elseif ($userValid && empty($success)) {echo "valid";} else {echo "";} ?>" 
				type="text" name="username" placeholder="Choose a username" value="<?php if (empty($success)) {echo $uname;} ?>"><br/>
				
				<span class="error-text left"><?php echo $passErr; ?></span>
				<input class="<?php if (!empty($passErr)) {echo "error";} ?>" 
				type="password" name="password" placeholder="Password" ><br/>
				
				<input class="<?php if (!empty($passErr)) {echo "error";} ?>" 
				type="password" name="passwordConfirm" placeholder="Confirm password" ><br/>
				
				<input type="submit" value="CREATE USER" id="submit"/>
			</form>
    </section>
  </body>
</html>


