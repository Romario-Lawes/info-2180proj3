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
      <form action="redirect.php" method="post">
        <h1>Welcome to CheapoMail</h1>
        <input name="username" type="text" placeholder="Username">
        <input name="password" type="password" placeholder="Password">
        <input type="submit" name="login" value="LOGIN" id="submit">
        </div> 
      </form>
    </section>
  </body>
</html>

<?php
  $host = getenv('IP');
  $username = getenv('C9_USER');
  $password = '';
  $dbname = 'cheapomail';
  $adminPassword = password_hash("password123", PASSWORD_DEFAULT);
  
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  
  //Create Admin
  $stmt = $conn -> query("SELECT * FROM Users WHERE username='admin';");
  $adminCheck = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if (count($adminCheck) === 0) {
    $conn -> exec(" INSERT INTO Users (firstname, lastname, username, password) 
    VALUES ('Mr', 'Administrator', 'admin', '$adminPassword');");
  }
?>