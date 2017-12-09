<?php session_start(); ?>
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
      <a href= "index.php"><span class="right" id="logout">Logout</span></a>
      <span class="right hello">Hello, <?php echo $_SESSION["user"]; ?> </span>
    </header>
    <section>
    	<?php 
				require "connection.php";
				$stmt = $conn -> query("SELECT * FROM Users;");
			  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
			  echo '<div class="table-wrapper">
				    <table>
				      <thead>
				        <tr>
				          <th>ID</th>
				          <th>First Name</th>
				          <th>Last Name</th>
				          <th>Username</th>
				        </tr>
				      </thead>
				      <tbody>';
				foreach ($users as $row) {
				  echo '<tr>' . '<td>' . $row['id'] . '</td>' . '<td>' . $row['firstname'] . '</td>' .
				  '<td>' . $row['lastname'] . '</td>' . '<td>' . $row['username'] . '</td>' . '</tr>';
				}
				echo '</tbody></table></div>';
			?>
			<a href="admin.php"><input type="button" name="dashboard" value="RETURN TO DASHBOARD"/></a>
    </section>
  </body>
</html>