			
		<?php
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		$user = $_SESSION['user'];

		mysql_connect("localhost", "root","") or die(mysql_error());
		mysql_select_db("medawigi") or die("Cannot connect to database.");
		$query = mysql_query("Select * from accounts WHERE username = '$user'");
		$row = mysql_fetch_array($query);

		$accountID = $accountID = str_pad($row['accountID'], 4, '0', STR_PAD_LEFT);
		$firstName = $row['firstName'];
		$lastName = $row['lastName'];
		$middleName = $row['middleName'];
		$suffix = $row['suffix'];
		$email = $row['email'];
		$username = $row['username'];
		$password = $row['password'];
		$secretQuest = $row['secretQuest'];
		$answerQuest = $row['answerQuest'];
		$gender = $row['gender'];
		$race = $row['race'];
		$birthDate = $row['birthDate'];
		
		$month = substr($birthDate, 0, 2);
		$day = substr($birthDate, 3, 2);
		$year = substr($birthDate, 6, 2);
		?>
<html>
	<head>
		<title>Edit Account Page</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>		
	<div id="banner"></div>			
	<body><center></br></br>
		<h2>Edit Account</h2>	
		<table border="0" cellpadding="2" cellspacing="5" bgcolor="1490CC">
		<th colspan="2">Edit Account</th>
		<form action="editaccount.php" method="POST">			
			<tr><td>First Name: </td>
				<td><input type="text" name="firstName" value="<?php echo $firstName; ?>" required="required" maxlength="30"/></td></tr>
			<tr><td>Middle Initial*: </td>
				<td><input type="text" name="middleName" value="<?php echo $middleName; ?>" maxlength="1"/></td></tr>
			<tr><td>Last Name: </td>
				<td><input type="text" name="lastName" value="<?php echo $lastName; ?>" required="required" maxlength="30"/></td></tr>
			<tr><td>Suffix*: </td>
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
					<option value="What is your favorite color?"<?php if($secretQuest == 'What is your favorite color?') echo 'selected="selected"'; ?>>What is your favorite color?</option>
					<option value="What is your stripper name?"<?php if($secretQuest == 'What is your stripper name?') echo 'selected="selected"'; ?>>What is your stripper name?</option>
				</select></td></tr>
			<tr><td>Secret Answer: </td>
				<td><input type="text" name="answerQuest" value="<?php echo $answerQuest; ?>" required="required" maxlength="50"/></td></tr>
			<tr><td>Gender: </td>
				<td><f2>
					<input type="radio" name="gender" value="Male"<?php echo ($gender == 'Male')?'checked':'' ?>>Male<br>
					<input type="radio" name="gender" value="Female"<?php echo ($gender == 'Female')?'checked':'' ?>>Female<br>
					<input type="radio" name="gender" value="Other"<?php echo ($gender == 'Other')?'checked':'' ?>>Other<br>
					<input type="radio" name="gender" value="Unspecified"<?php echo ($gender == 'Unspecified')?'checked':'' ?>>Unspecified<br>
				</f2></td></tr>
			<tr><td>Race: </td>
				<td><select name="race"> 						
					<option value="American Indian or Alaska Native"<?php if($race == 'American Indian or Alaska Native') echo 'selected="selected"'; ?>>American Indian or Alaska Native</option>
					<option value="Asian"<?php if($race == 'Asian') echo 'selected="selected"'; ?>>Asian</option>
					<option value="Black or African American"<?php if($race == 'Black or African American') echo 'selected="selected"'; ?>>Black or African American</option>
					<option value="Native Hawaiian or Other Pacific Islander"<?php if($race == 'Native Hawaiian or Other Pacific Islander') echo 'selected="selected"'; ?>>Native Hawaiian or Other Pacific Islander</option>
					<option value="White"<?php if($race== 'White') echo 'selected="selected"'; ?>>White</option>
					<option value="Other"<?php if($race == 'Other') echo 'selected="selected"'; ?>>Other</option>
					<option value="Unspecified"<?php if($race == 'Unspecified') echo 'selected="selected"'; ?>>Unspecified</option>
				</select></td></tr>
			<tr><td>Date of Birth: </td>
				<td><select name="month">
					<option value="01"<?php if($month == '01') echo 'selected="selected"'; ?>>January</option>
					<option value="02"<?php if($month == '02') echo 'selected="selected"'; ?>>February</option>
					<option value="03"<?php if($month == '03') echo 'selected="selected"'; ?>>March</option>
					<option value="04"<?php if($month == '04') echo 'selected="selected"'; ?>>April</option>
					<option value="05"<?php if($month == '05') echo 'selected="selected"'; ?>>May</option>
					<option value="06"<?php if($month == '06') echo 'selected="selected"'; ?>>June</option>
					<option value="07"<?php if($month == '07') echo 'selected="selected"'; ?>>July</option>
					<option value="08"<?php if($month == '08') echo 'selected="selected"'; ?>>August</option>
					<option value="09"<?php if($month == '09') echo 'selected="selected"'; ?>>September</option>
					<option value="10"<?php if($month == '10') echo 'selected="selected"'; ?>>October</option>
					<option value="11"<?php if($month == '11') echo 'selected="selected"'; ?>>November</option>
					<option value="12"<?php if($month == '12') echo 'selected="selected"'; ?>>December</option>
				</select>
				<select name="day">
					<?php for($i=31; $i>=1; $i--){ 
						if($i<10){ 
							if($day == $i){
								echo "<option value='0$i' selected>$i</option>";}
							else{
								echo "<option value='0$i'>$i</option>";}}
						else{
							if($day == $i){
								echo "<option value='$i' selected>$i</option>";}
							else{
								echo "<option value='$i'>$i</option>";}}}
					?>
				</select>
				<select name="year">
					<?php for($i=1, $j=date("Y"); $i<=80; $i++, $j--){
						$k=$j%100;
						if($year == $k){
							echo "<option value='$k' selected>$j</option>";}
						else{
							echo "<option value='$k'>$j</option>";}}
					?>
				</select></td></tr>
			<tr><td>*optional</td></tr>
			<tr><td colspan="2" align="center">
				<a href="myportal.php"><input type="button" value="Cancel" class="basic_button"/></a>
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
		mysql_query("UPDATE accounts SET firstName='$firstName', lastName='$lastName', middleName='$middleName', suffix='$suffix', email='$email', username='$username', password='$password', secretQuest='$secretQuest', answerQuest='$answerQuest', gender='$gender', race='$race', birthDate='$birthDate' WHERE accountID = '$accountID'");

		// It will be necessary to remove this later, it is dependent on the default nickname
		$query = mysql_query("Select * from persons");
		while($row = mysql_fetch_array($query))
		{
			$table_id = $row['personID'];   		
			$table_aid = substr($row['apid'], 0, 4);
			$table_nn = $row['nickname']; 		
			if($accountID == $table_aid && 'Me' == $table_nn)
			{
				$personID = $row['personID'];
				mysql_query("UPDATE persons SET firstName='$firstName', lastName='$lastName', middleName='$middleName', suffix='$suffix', gender='$gender', race='$race', birthDate='$birthDate' WHERE personID = '$personID'");	
			}
		}

		Print '<script>alert("Successfully changed!");</script>';
		Print '<script>window.location.assign("myportal.php");</script>'; 
	}
}
?> 