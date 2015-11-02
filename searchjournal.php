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
	
	if(isset($_POST['submit'])){
		if(isset($_GET['subject'])){
			$name=$_POST['criteria'];
			mysql_connect("localhost", "root","") or die(mysql_error());
			mysql_select_db("medawigi") or die("Cannot connect to database.");
			$query = mysql_query("Select * from persons WHERE personID = '$id'");	
			$row = mysql_fetch_array($query);				
			$apid = $row['apid'];			
			$query = mysql_query("Select * from journal WHERE apid = '$apid' AND journalSubject = '$name'");
			while($row = mysql_fetch_array($query)){
					
				$journalID = $row['journalID'];
				$date = $row['journalDate'];
				$time = $row['journalTime'];
				$subject = $row['journalSubject'];
				$content = $row['journalContent'];
					
				echo "<ul>\n";
				echo "<li>" . "<a href=\"search.php?id=$journalID\">" . $date . " " . $time . " " . $subject . " " . $content . "</a></li>\n";
				echo "</ul>";	
			}
		}
	}
?>

