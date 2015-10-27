<?php
/*
	session_start();
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	$bool = true;

	mysql_connect("localhost","root","") or die(mysql_error()); //Connect to server
	mysql_select_db("medawigi") or die ("Cannot connect to database");// Connect to database
	$query = mysql_query("SELECT * from 'accounts' WHERE username='$username'"); //Query the accounts table
	
	//Checks if username exists
	//$exists=mysql_num_rows($query);


	$table_users = "";
	$table_password= "";

	if(mysql_num_rows($query)==1)//if there are no returning rows or no existing username
	{

		$row = mysql_fetch_assoc($query); //display all rows from query
		//the first username row is passed on to $table_users, and so on until 
		//the query is finished
		$table_users= $row['username']; 

		//the first password row is passed on to $table_password, and so on until the query is finished
		$table_password= $row['password'];

		//checks if there are any matching fields
		if(($username == $table_users) && ($password == $table_password))
		
		{
			if($password == $table_password)
			{
				//set the username in a session.  This serves as a global
				$_SESSION['user'] = $username;

				//redirects the user to their portal	
				header("location: myportal.php");

			}
		}
		else
		{
			//Prompts the user
			Print '<script> alert("Incorrect Password!!"); </script>' ;
			//redirects to index.php
			Print '<script> window.location.assign("index.php");</script>';
			//Print '<html><input type="text" name="username" value="<?php echo $username;//>" /> </html>';

		}
	}
	else
	{
		
		//prompts the user
		Print'<script>alert("Incorrect Username!!");</script>';
		//redirects to index.php
		Print'<script>window.location.assign("index.php"); </script?';

	}
	*/

	 session_start();
    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);
    $bool = true;

    mysql_connect("localhost", "root", "") or die (mysql_error()); //Connect to server
    mysql_select_db("first_db") or die ("Cannot connect to database"); //Connect to database
    $query = mysql_query("Select * from accounts WHERE username='$username'"); // Query the users table
    $exists = mysql_num_rows($query); //Checks if username exists
    $table_users = "";
    $table_password = "";
    if($exists > 0) //IF there are no returning rows or no existing username
    {
       while($row = mysql_fetch_assoc($query)) // display all rows from query
       {
          $table_users = $row['username']; // the first username row is passed on to $table_users, and so on until the query is finished
          $table_password = $row['password']; // the first password row is passed on to $table_password, and so on until the query is finished
       }
       if(($username == $table_users) && ($password == $table_password))// checks if there are any matching fields
       {
          if($password == $table_password)
          {
             $_SESSION['user'] = $username; //set the username in a session. This serves as a global variable
             header("location: myportal.php"); // redirects the user to the authenticated home page
          }
       }
       else
       
        Print '<script>alert("Incorrect Password!");</script>'; // Prompts the user
        Print '<script>window.location.assign("index.php");</script>'; // redirects to login.php
        Print '<html><input type="text" name="username" value="<?php echo $username; ?>" /> </html>'
       
    }
    else
    {
        Print '<script>alert("Incorrect username!");</script>'; // Prompts the user
        Print '<script>window.location.assign("index.php");</script>'; // redirects to login.php
    }
?>
