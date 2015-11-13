<!-- 	EDIT ACCOUNT PAGE
		User account edit form
		Input validation - especially password, username, email
		Updates accounts and persons table
 -->			
		<?php
        include 'connect.php'; 

		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		$user = $_SESSION['user'];

		$query = mysql_query("Select * from accounts WHERE username = '$user'");
		$row = mysql_fetch_array($query);

		$accountID = $row['accountID'];
		$firstName = $row['firstName'];
		$lastName = $row['lastName'];
		$middleName = $row['middleName'];
		$suffix = $row['suffix'];
		$email = $row['email'];
		$username = $row['username'];
		$password = $row['password'];
		$secretQuest = $row['secretQuest'];
		$answerQuest = $row['answerQuest'];

		?>
<html>
	<head>
		<title>Edit Account Page</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>				
	<body><center><br/><br/>
		<h2>Edit Account</h2>	
        <div class="wrapper">    
		<table class="table1" cellpadding="2" cellspacing="5">
		<th colspan="2">Edit Account</th>
		<form action="editaccount.php" method="POST">			
			<tr><td>First Name: </td>
				<td><input type="text" name="firstName" value="<?php echo $firstName; ?>" required="required" maxlength="30"/></td></tr>
			<tr><td>Middle Initial: </td>
				<td><input type="text" name="middleName" value="<?php echo $middleName; ?>" maxlength="1"/></td></tr>
			<tr><td>Last Name: </td>
				<td><input type="text" name="lastName" value="<?php echo $lastName; ?>" required="required" maxlength="30"/></td></tr>
			<tr><td>Suffix: </td>
				<td><select name="suffix">
					<option value=""<?php if($suffix == '') echo 'selected="selected"'; ?>></option>
					<option value="Jr"<?php if($suffix == 'Jr') echo 'selected="selected"'; ?>>Jr</option>
					<option value="Sr"<?php if($suffix == 'Sr') echo 'selected="selected"'; ?>>Sr</option>
					<option value="III"<?php if($suffix == 'III') echo 'selected="selected"'; ?>>III</option>
				</select></td></tr>
			<tr><td>Email: </td>
				<td><input type="text" name="email" value="<?php echo $email; ?>" required="required" maxlength="30"/></td></tr>
			<tr><td>Username: </td>
				<td><input type="text" name="username" value="<?php echo $username; ?>" required="required" maxlength="15"/></td></tr>
			<tr><td>Password: </td>
				<td><input type="password" name="pass1" value="<?php echo $password; ?>"required="required" maxlength="15"/></td></tr>
			<tr><td>Confirm Password: </td>
				<td><input type="password" name="pass2" required="required" maxlength="15"/></td></tr>
			<tr><td>Secret Question: </td>
				<td><select name="secretQuest">
					<option value="What is your favorite color?"<?php if($secretQuest == "What is your favorite color?") echo 'selected="selected"'; ?>>What is your favorite color?</option>
                    <option value="What is your stripper name?"<?php if($secretQuest == "What is your stripper name?") echo 'selected="selected"'; ?>>What is your stripper name?</option>
					<option value="What was your mother's maiden name?"<?php if($secretQuest == "What was your mother's maiden name?") echo 'selected="selected"'; ?>>What was your mother's maiden name?</option>                    
				</select></td></tr>
			<tr><td>Secret Answer: </td>
				<td><input type="text" name="answerQuest" value="<?php echo $answerQuest; ?>" required="required" maxlength="50"/></td></tr>
			<tr><td></td></tr>
            <tr><td></td>
				<td><a href="myportal.php"><input type="button" value="Cancel" class="basic_button"/></a>
				<input type="submit" value="Submit" class="basic_button"></td></tr> 
		</form>
		</table>
    </div></center></body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$firstName = mysql_real_escape_string($_POST['firstName']);
	$lastName = mysql_real_escape_string($_POST['lastName']);
	$middleName = mysql_real_escape_string($_POST['middleName']);
	$suffix = mysql_real_escape_string($_POST['suffix']);
	$email = mysql_real_escape_string($_POST['email']);
	$username = mysql_real_escape_string($_POST['username']);
	$pass1 = mysql_real_escape_string($_POST['pass1']);
	$pass2 = mysql_real_escape_string($_POST['pass2']);
	$secretQuest = mysql_real_escape_string($_POST['secretQuest']);
	$answerQuest = mysql_real_escape_string($_POST['answerQuest']);
		
	$bool = true;
	
	// Validate password
	if($pass1 != $pass2)
	{
		$bool = false;
		Print '<script>alert("Passwords do not match!");</script>'; 
		Print '<script>window.location.assign("editaccount.php");</script>';
	}
	elseif(!(preg_match('~[A-Z]~', $pass1) && preg_match('~[a-z]~', $pass1) && preg_match('~[0-9]~', $pass1) && (strlen($pass1) >= 6)))
	{
		$bool = false;
		Print '<script>alert("Passwords must be at least 6 characters.\nPasswords must contain at least one lowercase letter.\nPasswords must contain at least one uppercase letter.\nPasswords must contain at least one number.");</script>'; 
		Print '<script>window.location.assign("editaccount.php");</script>';
	}	
	else
	{
		$password = $pass1;
	}
	
	// Validate email
	if(!(filter_var($email, FILTER_VALIDATE_EMAIL)))
	{
		$bool = false;
		Print '<script>alert("Invalid email!");</script>'; 
		Print '<script>window.location.assign("editaccount.php");</script>';		
	}
	
	// Check accounts table for duplicates
	$query = mysql_query("Select * from accounts"); 
	while($row = mysql_fetch_array($query)) 
	{
		$table_id = $row['accountID']; 
		$table_user = $row['username'];  
		if($username == $table_user && $accountID != $table_id)
		{
			$bool = false;
			Print '<script>alert("Username has been taken!");</script>';  
			Print '<script>window.location.assign("editaccount.php");</script>'; 
		}	
		$table_email = $row['email']; 
		if($email == $table_email && $accountID != $table_id)
		{
			$bool = false; 
			Print '<script>alert("Email already in use.");</script>'; 
			Print '<script>window.location.assign("editaccount.php");</script>'; 
		}	
	}

	// Write to tables
	if($bool) 
	{
		mysql_query("UPDATE accounts SET firstName='$firstName', lastName='$lastName', middleName='$middleName', suffix='$suffix', email='$email', username='$username', password='$password', secretQuest='$secretQuest', answerQuest='$answerQuest' WHERE accountID = '$accountID'");
        
        // Access personID associated with account
        $query = mysql_query("Select 0_personID from mappings WHERE accountID = '$accountID' limit 1");
        $personID = mysql_result($query, 0);
		     
        // Update persons table based upon personID
        mysql_query("UPDATE persons SET firstName='$firstName', lastName='$lastName', middleName='$middleName', suffix='$suffix' WHERE personID = '$personID'");

		Print '<script>alert("Successfully changed!");</script>';
		Print '<script>window.location.assign("myportal.php");</script>'; 
	}
}
?> 