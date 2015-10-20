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
		$accountID;

		mysql_connect("localhost", "root","") or die(mysql_error());
		mysql_select_db("medawigi") or die("Cannot connect to database.");
		$query = mysql_query("Select * from accounts");
		while($row = mysql_fetch_array($query))
		{
			$table_users = $row['username']; 
			if($user == $table_users) 
			{
				$accountID = $row['accountID'];
			}			
		}	
	
		$count = 0;
		$query = mysql_query("Select * from persons");
		while($row = mysql_fetch_array($query))
		{
			$table_second = $row['accountID']; 
			if($accountID == $table_second) 
			{
				$count++;
				$nickname = $row['nickname'];
				?>
					<!-- display profile buttons-->
					<a href="default.php" class="profile_button"><?php echo htmlspecialchars($nickname); ?></a></br>
				<?php	
			}
		}
		if($count < 10)
		{
			?>
				<!-- display add button-->
				<a href="addperson.php" class="myportal_button">Add Person</a></br>
			<?php
		}
		?>
			<!-- display logout button-->
			<a href="logout.php" class="myportal_button">Logout</a>
		</form>
	</body>
</html>