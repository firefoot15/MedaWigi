<html>
	<head>
		<title>My Portal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		
		<h2 align="center">My Portal</h2>
		<form action="myportal.php" method="post">
		
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
		$query = mysql_query("Select * from persons WHERE accountID = '$accountID'");
		while($row = mysql_fetch_array($query))
		{
			$count++;
			$nickname = $row['nickname'];
			$personID = $row['personID'];
			?>
				<!-- display profile buttons-->
				<a href="editperson.php?id=<?php echo htmlspecialchars($personID); ?>" class="profile_button"><?php echo htmlspecialchars($nickname); ?></a>
				<a href="deleteperson.php?id=<?php echo htmlspecialchars($personID); ?>">Delete Person</a><br/>
			<?php	
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