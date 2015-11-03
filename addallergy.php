	
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
		mysql_select_db("medawigi") or die("Cannot connect to database"); 
		$query = mysql_query("Select * from persons WHERE personID = '$id'");
		$row = mysql_fetch_array($query);		
		$apid = $row['apid'];	
		
		if($_SERVER["REQUEST_METHOD"] == "POST"){ 
			$name = mysql_real_escape_string($_POST['name']);
			$type = mysql_real_escape_string($_POST['type']);
			$severity = mysql_real_escape_string($_POST['severity']);

			mysql_query("INSERT INTO allergies (allergyName, allergyType, allergySeverity, apid) VALUES ('$name','$type','$severity','$apid')"); 	

			Print '<script>alert("Successfully added!");</script>';
			Print '<script>window.location.assign("allergies.php");</script>'; 
}
		?>
		