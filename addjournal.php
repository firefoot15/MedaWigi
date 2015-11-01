<?php
	session_start();
	if($_SESSION['user']){ }
	else{
		header("location:index.php");}

	if($_SERVER['REQUEST_METHOD'] = "POST") 
	{
		//THIS DOESN'T SET APID - MIGHT NOT NEED?
		$month = mysql_real_escape_string($_POST['month']);
		$day = mysql_real_escape_string($_POST['day']);
		$year = mysql_real_escape_string($_POST['year']);
		$hour = mysql_real_escape_string($_POST['hour']);
		$minute = mysql_real_escape_string($_POST['minute']);
		$period = mysql_real_escape_string($_POST['period']);		
		$time = mysql_real_escape_string($_POST['time']);
		$subject = mysql_real_escape_string($_POST['subject']);
		$content = mysql_real_escape_string($_POST['content']);
		
		$date = $month.'-'.$day.'-'.$year;
		$time = $hour.':'.$minute.' '.$period;

		mysql_connect("localhost", "root","") or die(mysql_error()); 
		mysql_select_db("medawigi") or die("Cannot connect to database"); 

		mysql_query("INSERT INTO journal (journalDate, journalTime, journalSubject, journalContent) VALUES ('$date','$time','$subject','$content')");
		header("location:journal.php");
	}
	else
	{
		header("location:journal.php"); // Redirects back to home
	}
?>