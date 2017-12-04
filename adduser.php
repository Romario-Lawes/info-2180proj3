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
			<form action = "admin.php" method="post">
				<h1 class="new">Create New User</h1>
				<input type="text" name="firstname" id="fname" placeholder="First Name"><br/>
				<input type="text" name="lastname" id="lname" placeholder="Last Name"><br/>
				<input type="text" name="username" id="uname" placeholder="Choose a username"><br/>
				<input type="password" name="password" id="pword" placeholder="Password"><br/>
				<input type="password" name="passwordConfirm" id="pwordConfirm" placeholder="Confirm password"><br/>
				<input type="submit" value="SUBMIT" id="submit"/>
			</form>
    </section>
  </body>
</html>

<?php
	session_start();
	
	$init_id= 1;
	
	if ((isset($fname)) && (isset($lname)) && (isset($uname)) && (isset($pword))) {
		$checkUpperCase = preg_match('/[A-Z]+/', $pword);
		$checkDigit = preg_match('/\d/', $pword);
		$checklength = (strlen($pword)>=8);
	  
	  //Checking that password is valid.
	    if(!$checkUpperCase || !$checkDigit || !$checklength){ 
	    	echo 'Invalid password';
		} else {
			$hashed_pword= password_hash($pword, PASSWORD_DEFAULT);
			$query= "INSERT INTO Users (id, firstname, lastname, username, password) VALUES (++$init_id, $fname, $lname, $uname, $hashed_pword);";
	    	if (mysql_query($query)){
	    		echo "<h2>User information added successfully</h2>";
	    	}
		}
	}

?>
