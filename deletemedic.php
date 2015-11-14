<!-- 	DELETE MEDICATION PAGE
		Receives medicID and deletes single row from table.
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
		mysql_query("DELETE FROM medications WHERE medicID='$id'");
		header("location:medications.php");
	}
?>