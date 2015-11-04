<?php
/**
File designed to coonnect to database
Type include 'connect.php': at the start of a php file to get it going!
Modualization at its finest
*/
mysql_connect("localhost", "root", "") or die(mysql_error()); 
	mysql_select_db("medawigi") or die("Cannot connect to database.");
?>