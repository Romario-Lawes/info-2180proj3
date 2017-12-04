<?php
  $host = getenv('IP');
  $username = getenv('C9_USER');
  $password = '';
  $dbname = 'cheapomail';
  $adminPassword = password_hash("password123", PASSWORD_DEFAULT);
  
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  
  $stmt = $conn->query("SELECT username, password FROM Users WHERE username='admin'");
  $admin = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  if (htmlentities($_POST["username"]) === $admin[0]["username"] && password_verify(htmlentities($_POST["password"]), $admin[0]["password"])) {
    header('Location: admin.php');
  } else {
    header('Location: user.php');
  }
  
?>