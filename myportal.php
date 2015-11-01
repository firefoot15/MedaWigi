<div id="wrapper">
<html>
	<head>
		<title>My Portal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<h2>M y P o r t a l </h2>
	<div id="banner"></div>
	<body><center>
		<form action="myportal.php" method="POST"></br>

		<?php
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		$user = $_SESSION['user'];

		mysql_connect("localhost", "root","") or die(mysql_error());
		mysql_select_db("medawigi") or die("Cannot connect to database.");
		$query = mysql_query("Select * from accounts WHERE username = '$user'");
		$row = mysql_fetch_array($query);
		$accountID = $row['accountID'];
	
		$count = 0;
		$query = mysql_query("Select * from persons");
		while($row = mysql_fetch_array($query))
		{  		
			$table_aid = substr($row['apid'], 0, 4);	
			if($accountID == $table_aid)
			{
				$count++;
				$nickname = $row['nickname'];
				$personID = $row['personID'];
				$avatarPath = $row['profilepic'];
				?>
					<!-- display profile buttons-->				
					<a href="journal.php?id=<?php echo htmlspecialchars($personID); ?>" class="profile_button"><img src="<?php echo htmlspecialchars($avatarPath); ?>"/><?php echo "\t\t".htmlspecialchars($nickname); ?></a></br>
					
					<!-- display delete person link-->
					<a href="deleteperson.php?id=<?php echo htmlspecialchars($personID); ?>" onClick="window.location.reload()"><img src="images/deleteButton.png" height="11" width="11"/> Delete <?php echo htmlspecialchars($nickname); ?></a><br/></br>
				<?php	
			}
		}
		if($count < 10)
		{
			?>
				<!-- display add person button-->
				<a href="addperson.php" class="myportal_button" value="">Add Person</a></br></br>
			<?php
		}
		?>
			<!-- display edit account button-->
			<a href="editaccount.php" class="myportal_button">Edit Account</a></br></br>
			<!-- display logout button-->
			<a href="logout.php" class="myportal_button">Logout</a>
		</form>
	</center></body>
</html></div>