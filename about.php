
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
		?>
<html>
	<head>
		<title>About</title>

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
		<h2>ABOUT</h2>
        <div class="wrapper"> 
		<p><b>MedaWigi</b><br><br>When you want it, you got it, all your medical<br>information in one place, supplied by MedaWigi!</p>
		<p>For more information or to report<br>problems, contact the authors:<br>.<br>.<br>.<br></p>
		<a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>" class="basic_button2">Return to Home</a>
    </div></center></body>
</html>	