		
		<?php
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		if($_SESSION['id']){ }
		else{
			header("location:myportal.php");}

		$user = $_SESSION['user'];			
		$id = $_SESSION['id'];	
		
		mysql_connect("localhost", "root","") or die(mysql_error());
		mysql_select_db("medawigi") or die("Cannot connect to database.");
		$query = mysql_query("Select * from persons WHERE personID = '$id'");
		$row = mysql_fetch_array($query);			
		$nickname = $row['nickname'];
		$firstName = $row['firstName'];
		$birthDate = $row['birthDate'];

		$month = substr($birthDate, 3, 2);
		$day = substr($birthDate, 6, 2);

		$reformatted_date = $month.'/'.$day;		
		
		?>
<html>
	<head>
		<title>Home</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<div id="banner"></div>	
	<body><center></br></br>
		<h2>H o m e</h2>
		<th>Welcome <?php if($nickname == 'Me')echo htmlspecialchars($firstName); else echo htmlspecialchars($nickname);?>!</th></br></br>
		<th><?php if(date("m/d" == $reformatted_date)) echo 'Happy Birthday!'; ?></th></br></br>
		<table border="0" cellpadding="5" cellspacing="5" bgcolor="#1490CC">
		<th colspan="3">Options:</th>
			<tr><td><a href="editperson.php" class="basic_button">Edit Person</a></td>
			<td><a href="journal.php" class="basic_button">Journal</a></td>
			<td><a href="myportal.php" class="basic_button">Return to Portal</a></td>
			<td><a href="logout.php" class="basic_button">Logout</a></td></tr>
			
		</table>

		
	</center></body>
</html>		