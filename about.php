
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
	</head>	   
	<body><center></br></br>
		<h2>About</h2>
        <div class="wrapper"> 
		<p><b>MedaWigi</b><br><br>When you want it, you got it, all your medical<br>information in one place, supplied by MedaWigi!</p>
		<p>For more information or to report<br>problems, contact the authors:<br>.<br>.<br>.<br></p>
		<a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>" class="basic_button2">Return to Home</a>
    </div></center></body>
</html>	