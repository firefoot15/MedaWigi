<!-- 	PERSON HOME
		Home page for individual profiles
		All person specific pages are routed through here including: 
		journal, calendar?, medications, insurance...
 -->			
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
		<h2>H O M E</h2>
		<th>Welcome <?php if($nickname == 'Me')echo htmlspecialchars($firstName); else echo htmlspecialchars($nickname);?>!</th></br></br>
		<th><?php if(date("m/d" == $reformatted_date)) echo 'Happy Birthday!'; ?></th></br></br>
		<table border="0" cellpadding="5" cellspacing="5" bgcolor="#1490CC">
		<th colspan="3">Options:</th>
			<tr><td><a href="editperson.php" class="basic_button2">Edit Person</a></td>
			<td><a href="ice.php" class="basic_button2">ICE</a></td>
			<td><a href="journal.php" class="basic_button2">Journal</a></td></tr>

			
			<tr><td><a href="allergies.php" class="basic_button2">Allergies</a></td>
			<td><a href="medications.php" class="basic_button2">Medications</a></td>
			<td><a href="insurance.php" class="basic_button2">Insurance</a></td></tr>		
			
			<tr><td><a href="contact.php" class="basic_button2">Contact Us</a></td>
			<td><a href="myportal.php" class="basic_button2">Return to Portal</a></td>
			<td><a href="logout.php" class="basic_button2">Logout</a></td></tr>		
			<!-- add current condition notebox -->
		</table>

		
	</center></body>
</html>		