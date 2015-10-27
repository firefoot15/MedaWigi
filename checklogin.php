<?php
	session_start();
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	mysql_connect("localhost", "root","") or die(mysql_error()); 
	mysql_select_db("medawigi") or die("Cannot connect to database");
	$query = mysql_query("SELECT * from accounts WHERE username='$username'");
	$exists = mysql_num_rows($query); 
	$table_users = "";
	$table_password = "";
	if($exists > 0) // IF there are no returning rows or no existing username
	{
		while($row = mysql_fetch_assoc($query)) // Display all rows from query
		{
			$table_users = $row['username']; // The first username row is passed on to $table_users, and so on until the query is finished
			$table_password = $row['password']; // The first password row is passed on to $table_users, and so on until the query is finished
		}
		if(($username == $table_users) && ($password == $table_password)) // Checks if there are any matching fields
		{
				if($password == $table_password)
				{
					$_SESSION['user'] = $username; // Set the username in a session. This serves as a global variable
					header("location: myportal.php"); // Redirects the user to the authenticated home page
				}	
		}
		else
		{
			Print '<script>alert("Incorrect Password!");</script>'; // Prompts the user
			Print '<script>window.location.assign("login.php");</script>'; // Redirects to login.php
		}
	}
	else
	{
		Print '<script>alert("Incorrect Username!");</script>'; // Prompts the user
		Print '<script>window.location.assign("login.php");</script>'; // Redirects to login.php
	}
?>