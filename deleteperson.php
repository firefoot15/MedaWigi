<?php
	session_start(); 
	if($_SESSION['user']){ }
	else{
		header("location:index.php");}
	
	// Only deletes row, doesn't check link
	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		mysql_connect("localhost", "root","") or die(mysql_error()); 
		mysql_select_db("medawigi") or die("Cannot connect to database"); 
		$id = $_GET['id'];
		mysql_query("DELETE FROM persons WHERE personID='$id'");
		header("location:myportal.php");
	}
?>