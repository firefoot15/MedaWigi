<!-- 	MY PORTAL
		Home page for account
		Selection of profiles to view/delete
		Caps number of profiles at 10
		Edit account, add person & logout option
 -->		

<html>
	<head>
		<title>My Portal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<h2>My Portal</h2>
    <div class="wrapper">
	<div id="banner"></div>
	<body><center>    
		<form action="myportal.php" method="POST"><br/>
		<?php
        
        include 'connect.php'; 
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		$user = $_SESSION['user'];

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
				$avatarPath = $row['profilepic'];
				
				// Create session ID	
				$_SESSION['id'] = $row['personID'];
				?>
					<!-- display profile buttons-->				
					<a href="personhome.php" class="profile_button"><img src="<?php echo htmlspecialchars($avatarPath); ?>"/><?php echo "\t\t".htmlspecialchars($nickname); ?></a><br>
					
					<!-- display delete person link-->
					<a href="deleteperson.php?id=<?php echo htmlspecialchars($row['personID']); ?>" onClick="window.location.reload()"><img src="images/deleteButton.png" height="11" width="11"/> Delete <?php echo htmlspecialchars($nickname); ?></a><br/><br/>
				<?php	
			}
		}
		if($count < 10)
		{
			?>
				<!-- display add person button-->
				<a href="addperson.php" class="myportal_button" value="">Add Person</a><br/><br/>
			<?php
		}
		?>
			<!-- display edit account button-->
			<a href="editaccount.php" class="myportal_button">Edit Account</a><br/><br/>
			<!-- display logout button-->
			<a href="logout.php" class="myportal_button">Logout</a>
		</form>
    </center></body></div>
</html>