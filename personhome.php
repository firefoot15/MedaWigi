<!-- 	PERSON HOME
		Home page for individual profiles
		All person specific pages are routed through here including: 
		journal, calendar?, medications, insurance...
 -->			
		<?php

        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		if($_GET['id']){ }
		else{
			header("location:myportal.php");}

		$user = $_SESSION['user'];			
		$id = $_GET['id'];	

            // Create sessionID	
			$_SESSION['id'] = $id;
		
		$query = mysql_query("Select * from persons WHERE personID = '$id'");
		$row = mysql_fetch_array($query);			
		$nickname = $row['nickname'];
		$firstName = $row['firstName'];
		$birthDate = $row['birthDate'];

		$month = substr($birthDate, 5, 2);
		$day = substr($birthDate, 8, 2);

		$reformatted_date = $month.'/'.$day;
        date_default_timezone_set('America/New_York');
		
		?>
<html>
	<head>
		<title>Home</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<script src="medawigi.js"></script>
</head>
<div class="top">
  <div id="logo">
    <img />
    
  </div>
  <div class="sammich">
    <img onclick="menu()" class="sammich" src="https://cdn2.iconfinder.com/data/icons/menu-elements/154/round-border-menu-bar-128.png" />



    <div class="menu">
      <ul id="menu-list">
        <br>
        <li id="home"><a href="personhome.php">Home</a></li>
        <br>
        <li id="insurance_contact"><a href="insurance.php">Insurance</a></li>
        <br>
        <li id="calendar"><a href="calendar.php">Calendar</a></li>
        <br>
        <li id="journal"><a href="journal.php">Journal</a></li>
        <br>
        <li id="medications"><a href="medication.php">Medications</a></li>
        <br>
        <li id="allergies"><a href="allergies.php">Allergies</a></li>
        <br>
	<li id="immunizations"><a href="immunizations.php">Immunizations</a></li>
	<br>
	<li id="contacts"><a href="contacts.php">Contacts</a></li>
	<br>
	<li id="conditions"><a href="conditions.php">Conditions</a></li>
	<br>
        <li id="contact"><a href="contact.html">Contact us</a></li>
        <br>
        <li id="editprofile"><a href="editprofile.php">Edit Profile</a></li>
        <br>
        <li id="switch_profile"><a href="#">Switch Profile</a></li>
        <br>
        <li id="logout"><a href="logout.php">Logout</a></li>
        <br>
      </ul>
    </div>
  </div>

</div>


	<body><center></br></br>
		<h2>H O M E</h2>
        <div class="wrapper">
        <th2><b><?php if($nickname == 'Me')echo 'My'; else echo htmlspecialchars($nickname)."'s";?> Page</b></th2></br></br>
        <th><?php if(date("m/d") == $reformatted_date) echo 'Happy Birthday!'; ?></th></br></br>
		<table class="table4" cellpadding="5" cellspacing="5">
		<th3 colspan="2">OPTIONS:</th3>
			<tr><td><a href="medications.php" class="basic_button2">Medications</a></td>
            <td><a href="calendar.php" class="basic_button2">Calendar</a></td></tr>

			<tr><td><a href="immunizations.php" class="basic_button2">Immunizations</a></td>
            <td><a href="journal.php" class="basic_button2">Journal</a></td></tr>
			
            <tr><td><a href="allergies.php" class="basic_button2">Allergies</a></td>
			<td><a href="insurance.php" class="basic_button2">Insurance</a></td></tr>
			
            <tr><td><a href="conditions.php" class="basic_button2">Conditions</a></td>
            <td><a href="contacts.php" class="basic_button2">Contacts</a></td></tr>
            
            <tr><td><a href="editperson.php" class="basic_button2">Edit Person</a></td>
            <td><a href="about.php" class="basic_button2">About</a></td></tr>
			
            <tr><td><a href="myportal.php" class="basic_button2">Return to Portal</a></td>
			<td><a href="logout.php" class="basic_button2">Logout</a></td></tr>
		</table>

		
    </div></center></body>
</html>		