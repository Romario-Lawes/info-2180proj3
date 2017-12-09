<?php
  $host = getenv('IP');
  $username = getenv('C9_USER');
  $password = '';
  $dbname = 'cheapomail';
  
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  
  function sanitize($data) {
    return htmlspecialchars(stripcslashes(trim($data)));
  }
?>