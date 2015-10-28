<html>
	<head>
		<title>Registration Page</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body><center>
		<table border="0" cellpadding="2" cellspacing="5" bgcolor="#202020">
		<th colspan="2" align="center">Create Account</th>
		<form action="register.php" method="POST">
			<tr><td>First Name: </td>
				<td><input type="text" name="firstName" required="required" maxlength="30"/></td></tr>
			<tr><td>Middle Initial*: </td>
				<td><input type="text" name="middleName" maxlength="1"/></td></tr>
			<tr><td>Last Name: </td>
				<td><input type="text" name="lastName" required="required" maxlength="30"/></td></tr>
			<tr><td>Suffix*: </td>
				<td><select name="suffix">
					<option value=""></option>
					<option value="Jr">Jr</option>
					<option value="Sr">Sr</option>
					<option value="III">III</option>
				</select></td></tr>
			<tr><td>Email: </td>
				<td><input type="text" name="email" required="required" maxlength="30"/></td></tr>
			<tr><td>Username: </td>
				<td><input type="text" name="username" required="required" maxlength="15"/></td></tr>
			<tr><td>Password: </td>
				<td><input type="password" name="pass1" required="required" maxlength="15"/></td></tr>
			<tr><td>Confirm Password: </td>
				<td><input type="password" name="pass2" required="required" maxlength="15"/></td></tr>
			<tr><td>Secret Question: </td>
				<td><select name="secretQuest">
					<option value="What is your favorite color?">What is your favorite color?</option>
					<option value="What is your stripper name?">What is your stripper name?</option>
				</select></td></tr>
			<tr><td>Secret Answer: </td>
				<td><input type="text" name="answerQuest" required="required" maxlength="50"/></td></tr>
			<tr><td>Gender: </td>
				<td><f2>
					<input type="radio" name="gender" value="Male" checked>Male<br>
					<input type="radio" name="gender" value="Female" checked>Female<br>
					<input type="radio" name="gender" value="Other" checked>Other<br>
					<input type="radio" name="gender" value="Unspecified" checked>Unspecified<br>
				</f2></td></tr>
			<tr><td>Race: </td>
				<td><select name="race"> 						
					<option value="American Indian or Alaska Native">American Indian or Alaska Native</option>
					<option value="Asian">Asian</option>
					<option value="Black or African American">Black or African American</option>
					<option value="Native Hawaiian or Other Pacific Islander">Native Hawaiian or Other Pacific Islander</option>
					<option value="White">White</option>
					<option value="Other">Other</option>
					<option value="Unspecified">Unspecified</option>
				</select></td></tr>
			<tr><td>Date of Birth: </td>
				<td><select name="month">
					<option value="01">January</option>
					<option value="02">February</option>
					<option value="03">March</option>
					<option value="04">April</option>
					<option value="05">May</option>
					<option value="06">June</option>
					<option value="07">July</option>
					<option value="08">August</option>
					<option value="09">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
				</select>
				<select name="day">
					<?php for($i=31; $i>=1; $i--){
						if($i<10)
							echo "<option value='0$i' selected>$i</option>";
						else
							echo "<option value='$i' selected>$i</option>";}
					?>
				</select>
				<select name="year">
					<?php for($i=1, $j=date("Y"); $i<=80; $i++, $j--){
						$k=$j%100;
						echo "<option value='$k' selected>$j</option>";}
					?>
				</select></td></tr>
			<tr><td>*optional</td></tr>
			<tr><td colspan="2" align="center">
				<a href="index.php"><input type="button" value="Cancel" class="basic_button"/></a>
				<input type="submit" value="Submit" class="basic_button"></td></tr>
		</form>
		</table>
	</center></body>
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
	$gender = mysql_real_escape_string($_POST['gender']);
	$race = mysql_real_escape_string($_POST['race']);
	$month = mysql_real_escape_string($_POST['month']);
	$day = mysql_real_escape_string($_POST['day']);
	$year = mysql_real_escape_string($_POST['year']);
		

	$bool = true;
	$birthDate = $month.'-'.$day.'-'.$year;
	
	// Validate password
	if($pass1 != $pass2)
	{
		$bool = false;
		Print '<script>alert("Passwords do not match!");</script>'; 
		Print '<script>window.location.assign("register.php");</script>';
	}
	elseif(!(preg_match('~[A-Z]~', $pass1) && preg_match('~[a-z]~', $pass1) && preg_match('~[0-9]~', $pass1) && (strlen($pass1) >= 6)))
	{
		$bool = false;
		Print '<script>alert("Passwords must be at least 6 characters.\nPasswords must contain at least one lowercase letter.\nPasswords must contain at least one uppercase letter.\nPasswords must contain at least one number.");</script>'; 
		Print '<script>window.location.assign("register.php");</script>';
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
		Print '<script>window.location.assign("register.php");</script>';		
	}
	
	// Check accounts table for duplicates
	mysql_connect("localhost", "root", "") or die(mysql_error()); 
	mysql_select_db("medawigi") or die("Cannot connect to database."); 
	$query = mysql_query("Select * from accounts"); 
	while($row = mysql_fetch_array($query)) 
	{
		$table_user = $row['username']; 
		if($username == $table_user) 
		{
			$bool = false;
			Print '<script>alert("Username has been taken!");</script>'; 
			Print '<script>window.location.assign("register.php");</script>'; 
		}	
		$table_email = $row['email']; 
		if($email == $table_email) 
		{
			$bool = false; 
			Print '<script>alert("Email already in use.");</script>'; 
			Print '<script>window.location.assign("register.php");</script>'; 
		}	
	}
	
	// Write to tables
	if($bool) 
	{
		mysql_query("INSERT INTO accounts (firstName, lastName, middleName, suffix, email, username, password, secretQuest, answerQuest, gender, race, birthDate) VALUES ('$firstName','$lastName','$middleName','$suffix','$email','$username','$password','$secretQuest','$answerQuest','$gender','$race','$birthDate')"); 
		$accountID = str_pad(mysql_insert_id(), 4, '0', STR_PAD_LEFT);	
		
		mysql_query("INSERT INTO persons (firstName, lastName, middleName, suffix, gender, race, birthDate, nickname, apid) VALUES ('$firstName','$lastName','$middleName','$suffix','$gender','$race','$birthDate','Me','')"); 
		$personID = str_pad(mysql_insert_id(), 4, '0', STR_PAD_LEFT);	
		$apid = $accountID.$personID;
		mysql_query("UPDATE persons SET apid='$apid' WHERE personID = '$personID'");		
		
		Print '<script>alert("Successfully registered!");</script>';
		Print '<script>window.location.assign("index.php");</script>'; 
	}
} 
?> 