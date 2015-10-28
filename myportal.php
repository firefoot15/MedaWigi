<html>
	<head>
		<title>My Portal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		
		<h2 align="center">My Portal</h2>
		<form action="myportal.php" method="POST">
		
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
				echo '<img src="data:image/png;base64,'.base64_encode( $row['profilepic'] ).'"/>';
				?>
					<!-- display profile buttons-->
					<!--<link rel="stylesheet" type="text/css" media="screen" href="style.php?id=<?php //echo htmlspecialchars($personID); ?>>-->
				
					<a href="editperson.php?id=<?php echo htmlspecialchars($personID); ?>" class="profile_button"><?php echo htmlspecialchars($nickname); ?></a>
					<a href="deleteperson.php?id=<?php echo htmlspecialchars($personID); ?>">Delete <?php echo htmlspecialchars($nickname); ?></a><br/>
				<?php	
			}
		}
		if($count < 10)
		{
			?>
				<!-- display add person button-->
				<a href="addperson.php" class="myportal_button">Add Person</a></br>
			<?php
		}
		?>
			<!-- display edit account button-->
			<a href="editaccount.php" class="myportal_button">Edit Account</a></br>
			<!-- display logout button-->
			<a href="logout.php" class="myportal_button">Logout</a>
		</form>
	</body>
</html>