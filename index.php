<?php
  session_start();
  require "connection.php";
  
  $adminPassword = password_hash("password123", PASSWORD_DEFAULT);
  
  # Creates Admin
  $stmt = $conn -> query("SELECT * FROM Users WHERE username='admin';");
  $adminCheck = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if (count($adminCheck) === 0) {
    $conn -> exec(" INSERT INTO Users (firstname, lastname, username, password) 
    VALUES ('Mr', 'Administrator', 'admin', '$adminPassword');");
  }
  
  $userErr = "";
  $userValid = $passValid = false;
  $valid = true;
  $passReg = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
  $username = sanitize(strtolower($_POST["username"]));
  $password = sanitize($_POST["password"]);
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($username)) {
      $userErr = "Username is required";
      $valid = false;
    } else {
      $valid = true;
      $userErr = "";
      $userValid = true;
    }
    
    if (empty($password)) {
      $passErr = "Password is required";
      $valid = false;
    } else {
      if ($username === "admin") {
        $valid = true;
        $passErr = "";
      } else {
        if (!preg_match($passReg, $password)) {
          $passErr = "Minimum length: 8 characters. Must contain atleast one digit and one uppercase letter";
          $valid = false;
        } 
      }
    }
    
    if ($valid) {
      $stmt = $conn->query("SELECT username, password FROM Users WHERE username='$username'");
      $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $err =  "";
      
      if (count($user) > 0) {
        $_SESSION["user"] = $username;
        if ($username === $user[0]["username"] && $user[0]["username"] === "admin" && password_verify($password, $user[0]["password"])) {
          header('Location: admin.php');
        } elseif ($username === $user[0]["username"] && password_verify($password, $user[0]["password"])){
          header('Location: user.php');
        } else {
          $err = "Incorrect password";
        }
      } else {
        $err = "User doesn't exist";
      }
    }
    
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>CheapoMail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script type="text/javascript" src="login.js"></script>
  </head>
  <body>
    <header>
      <span id="logo">CheapoMail</span>
    </header>
    <section>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <h1>Welcome to CheapoMail</h1>
        
        <span class="error-text"><?php echo $err; ?></span>
        
        <span class="error-text left"><?php echo $userErr; ?></span>
        <input class="<?php if (!empty($userErr)) {echo "error";} elseif (($userValid && empty($err)) || $err === "Incorrect password") {echo "valid";} else {echo "";} ?>" name="username" 
        type="text" placeholder="Username" value="<?php echo $username; ?>">
        
        <span class="error-text left"><?php echo $passErr; ?></span>
        <input class="<?php if (!empty($passErr) || $err === "Incorrect password") {echo "error";} ?>" name="password" type="password" placeholder="Password">
        
        <input type="submit" name="login" value="LOGIN" id="submit">
        </div> 
      </form>
    </section>
  </body>
</html>