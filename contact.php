<!-- 	CONTACT/About Us
		Information about MedaWigi & authors
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
		?>
<html>
	<head>
		<title>Contact</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>	
	<div id="banner"></div>	
	<body><center></br></br>
		<h2>Contact</h2>
		<p><b>MedaWigi</b><br><br>When you want it, you got it, all your medical<br>information in one place, supplied by MedaWigi!</p>
		<p>For more information or to report<br>problems, contact the authors:<br>.<br>.<br>.<br></p>
		<a href="personhome.php" class="basic_button2">Return to Home</a>
	</center></body>
</html>	