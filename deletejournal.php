<!-- 	DELETE JOURNAL PAGE
		Receives journalID and deletes single row from table.
 -->

<?php
    include 'connect.php';
	session_start(); 
	if($_SESSION['user']){ }
	else{
		header("location:index.php");}

	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		$id = $_GET['id'];
		mysql_query("DELETE FROM events WHERE eventID='$id'");
		header("location:journal.php");
	}
?>