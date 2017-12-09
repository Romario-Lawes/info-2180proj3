<?php require "inbox.php"; ?>
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
      <a href="adduser.php"><input type="button" name="adduser" value="ADD NEW USER"/></a>
      <a href="viewusers.php"><input type="button" name="viewusers" value="VIEW ALL USERS"/></a>
			<h1 id="inbox-text">Inbox</h1>
			<div class="table-wrapper table-inbox">
				<a href="compose.php"><input type="button" name="compose" value="COMPOSE"/></a>
				<table id="inbox">
				<thead>
					<tr>
						<th>Sender</th>
						<th>Subject</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
				<?php
					echo $inboxMsgs;
				?>
				</tbody>
				</table>
				<input type="button" id="showAll" value="SHOW ALL MESSAGES"/>
				<input type="button" id="showLess" value="SHOW LESS"/>
			</div>
    </section>
  </body>
</html>

