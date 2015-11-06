<?php
    include 'connect.php';
	session_start(); 
	if($_SESSION['user']){ }
	else{
		header("location:index.php");}

	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		$id = $_GET['id'];
		mysql_query("DELETE FROM journal WHERE journalID='$id'");
		header("location:journal.php");
	}
?>