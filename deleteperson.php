<?php
	session_start(); // Starts the session
	if($_SESSION['user']){ // Checks if user is logged in
	}
	else{
		header("location:index.php"); // Redirects if user is not logged in
	}

	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		mysql_connect("localhost", "root","") or die(mysql_error()); // Connect to server
		mysql_select_db("medawigi") or die("Cannot connect to database"); // Connect to database
		$id = $_GET['id'];
		mysql_query("DELETE FROM persons WHERE id='$id'");
		header("location:myportal.php");
	}
?>