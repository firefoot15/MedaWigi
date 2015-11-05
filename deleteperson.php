<?php
    include 'connect.php';
	session_start(); 
	if($_SESSION['user']){ }
	else{
		header("location:index.php");}
	
	// Only deletes row, doesn't check link
	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		$id = $_GET['id'];
		mysql_query("DELETE FROM persons WHERE personID='$id'");
		header("location:myportal.php");
	}
?>