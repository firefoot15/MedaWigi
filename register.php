<!-- 	REGISTRATION PAGE
		User account registration form
		Input validation - especially password, username, email
		Write to accounts, persons, and mappings tables
 -->

<html>
	<head>
		<title>Registration</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<script src="medawigi.js"></script>
</head>
<div class="top">
  <div id="logo">
    <img />
    
  </div>
  <div class="sammich">
    <img onclick="menu()" class="sammich" src="https://cdn2.iconfinder.com/data/icons/menu-elements/154/round-border-menu-bar-128.png" />



    <div class="menu">
      <ul id="menu-list">
        <br>
        <li id="home"><a href="personhome.php">Home</a></li>
        <br>
        <li id="insurance_contact"><a href="insurance.php">Insurance</a></li>
        <br>
        <li id="calendar"><a href="calendar.php">Calendar</a></li>
        <br>
        <li id="journal"><a href="journal.php">Journal</a></li>
        <br>
        <li id="medications"><a href="medication.php">Medications</a></li>
        <br>
        <li id="allergies"><a href="allergies.php">Allergies</a></li>
        <br>
	<li id="immunizations"><a href="immunizations.php">Immunizations</a></li>
	<br>
	<li id="contacts"><a href="contacts.php">Contacts</a></li>
	<br>
	<li id="conditions"><a href="conditions.php">Conditions</a></li>
	<br>
        <li id="contact"><a href="contact.html">Contact us</a></li>
        <br>
        <li id="editprofile"><a href="editprofile.php">Edit Profile</a></li>
        <br>
        <li id="switch_profile"><a href="#">Switch Profile</a></li>
        <br>
        <li id="logout"><a href="logout.php">Logout</a></li>
        <br>
      </ul>
    </div>
  </div>

</div>
	
	<body>
		<h2>CREATE ACCOUNT</h2>
        <div class="wrapper">  
        <table class="page_table"><tr><td></td><td><center>        
		<h1>Sign Up!</h1>
        <table class="table1" cellpadding="2" cellspacing="5">
		<form action="register.php" method="POST">
			<tr><td>First Name: </td>
				<td><input type="text" name="firstName" required="required" maxlength="30"/></td></tr>
			<tr><td>Middle Initial: </td>
				<td><input type="text" name="middleName" maxlength="1"/></td></tr>
			<tr><td>Last Name: </td>
				<td><input type="text" name="lastName" required="required" maxlength="30"/></td></tr>
			<tr><td>Suffix: </td>
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
                    <option value="What was your mother's maiden name?">What was your mother's maiden name?</option>
				</select></td></tr>
			<tr><td>Secret Answer: </td>
				<td><input type="text" name="answerQuest" required="required" maxlength="50"/></td></tr>
			<tr><td>Gender: </td>
				<td><f2>
					<input type="radio" name="gender" value="Male">Male<br>
					<input type="radio" name="gender" value="Female">Female<br>
					<input type="radio" name="gender" value="Other">Other<br>
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
					<option value="Unspecified" selected>Unspecified</option>
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
                            echo "<option value='$j' selected>$j</option>";}
					?>
				</select></td></tr>
			<tr><td></td></tr>
            <tr><td></td>
				<td><a href="index.php"><input type="button" value="Cancel" class="basic_button"/></a>
				<input type="submit" value="Submit" class="basic_button"></td></tr>
		</form>
		</table>
        </center></td></tr></table>    
    </div></body>
</html>

<?php
include 'connect.php'; 

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
	$birthDate = $year.'-'.$month.'-'.$day;
	
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
		mysql_query("INSERT INTO accounts (firstName, lastName, middleName, suffix, email, username, password, secretQuest, answerQuest) VALUES ('$firstName','$lastName','$middleName','$suffix','$email','$username','$password','$secretQuest','$answerQuest')");
        // Grabs the auto-incremented accountID and stores it in accountID variable
        // No parameter means using most recent sql connection
		$accountID = mysql_insert_id();	
		$avatarPath = "images/profilepic".rand(1, 16).".png";
		
		mysql_query("INSERT INTO persons (firstName, lastName, middleName, suffix, gender, race, birthDate, nickname, profilepic) VALUES ('$firstName','$lastName','$middleName','$suffix','$gender','$race','$birthDate','Me','$avatarPath')"); 
        // Grabs the auto-incremented personID and stores it in personID variable
		$personID = mysql_insert_id();	
		
        // Mappings table designed to link different people and same accounts as needed
		mysql_query("INSERT INTO mappings (accountID, 0_personID) VALUES ('$accountID','$personID')");		
		
		Print '<script>alert("Successfully registered!");</script>';
		Print '<script>window.location.assign("index.php");</script>'; 
	}
} 
?> 