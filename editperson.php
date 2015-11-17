<!-- 	EDIT PERSON PAGE
		Edit form for individual profiles
		General input validation, no account information
		Link to avatar page
		Updates accounts and persons table
 -->		
		<?php

        include 'connect.php'; 
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		if($_SESSION['id']){ }
		else{
			header("location:myportal.php");}

		$user = $_SESSION['user'];			
		$id = $_SESSION['id'];	
		
		$query = mysql_query("Select * from persons WHERE personID = '$id'");
		$row = mysql_fetch_array($query);		

		$firstName = $row['firstName'];
		$lastName = $row['lastName'];
		$middleName = $row['middleName'];
		$suffix = $row['suffix'];
		$nickname = $row['nickname'];
		$gender = $row['gender'];
		$race = $row['race'];
		$birthDate = $row['birthDate'];
		
		$year = substr($birthDate, 0, 4);
		$month = substr($birthDate, 5, 2);
		$day = substr($birthDate, 8, 2);
		?>

<html>
	<head>
		<title>Edit Person Page</title>
		<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<script src="medawigi.js"></script>
	</head>
<div class="top">
  <div id="logo">
    <img src="http://medawigi.no-ip.org/images/logo.png";/>
  </div>
  <div class="sammich">
    <img onclick="menu()" class="sammich" src="https://cdn2.iconfinder.com/data/icons/menu-elements/154/round-border-menu-bar-128.png" />
    <div class="menu">
      <ul id="menu-list">
        <li id="home"><a href="personhome.php">Home</a></li>
        <li id="insurance_contact"><a href="insurance.php">Insurance</a></li>
        <li id="calendar"><a href="calendar.php">Calendar</a></li>
        <li id="journal"><a href="journal.php">Journal</a></li>
        <li id="medications"><a href="medications.php">Medications</a></li>
        <li id="allergies"><a href="allergies.php">Allergies</a></li>
	<li id="immunizations"><a href="immunizations.php">Immunizations</a></li>
	<li id="contacts"><a href="contacts.php">Contacts</a></li>
	<li id="conditions"><a href="conditions.php">Conditions</a></li>
        <li id="contact"><a href="contact.html">Contact us</a></li>
        <li id="editprofile"><a href="editprofile.php">Edit Profile</a></li>
        <li id="switch_profile"><a href="personhome.php">Switch Profile</a></li>
        <li id="logout"><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</div>
	<body>
		<h2>EDIT PERSON</h2>
        <div class="wrapper"> 
        <table class="page_table"><tr><td></td><td><center>
        <h1>Edit Person</h1>    
		<table class="table1" cellpadding="2" cellspacing="5">
		<form action="editperson.php" method="POST">
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
			<tr><td>Nickname: </td>
				<td><input type="text" name="nickname" value="<?php echo $nickname; ?>" required="required" maxlength="15"/></td></tr>
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
					<option value=""<?php if($month == '') echo 'selected="selected"'; ?>></option>                
				</select>
				<select name="day">
					<?php for($i=31; $i>=0; $i--){ 
						if($i == 0){
							if($day == $i){
								echo "<option value='' selected></option>";}
							else{
								echo "<option value=''></option>";}}							
						elseif($i<10){ 
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
					<?php for($i=0, $j=date("Y"); $i<=80; $i++, $j--){
						if(empty($year)){
							if($i == 80){
								echo "<option value='' selected></option>";}	
							else{
								echo "<option value='$j'>$j</option>";}}
						else{
							if($i == 80){
                                echo "<option value=''></option>";}
							else{
								if($year == $j){
									echo "<option value='$j' selected>$j</option>";}
								else{
									echo "<option value='$j'>$j</option>";}}}}
					?>
				</select></td></tr>
			<tr><td></td></tr>
            <tr><td></td>
				<td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Cancel" class="basic_button"/></a>
				<input type="submit" value="Submit" class="basic_button"/></td></tr> 
		</form>
		</table>
        <br>
        <br>    
        <a href="avatar.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Change Avatar" class="basic_button"/></a></br></br>
        </center></td></tr></table>
    </div></body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
	$firstName = mysql_real_escape_string($_POST['firstName']);
	$lastName = mysql_real_escape_string($_POST['lastName']);
	$middleName = mysql_real_escape_string($_POST['middleName']);
	$suffix = mysql_real_escape_string($_POST['suffix']);
	$nickname = mysql_real_escape_string($_POST['nickname']);
    $gender = mysql_real_escape_string($_POST['gender']);
	$race = mysql_real_escape_string($_POST['race']);
	$month = mysql_real_escape_string($_POST['month']);
	$day = mysql_real_escape_string($_POST['day']);
	$year = mysql_real_escape_string($_POST['year']);
	
	$id = $_SESSION['id'];
    
	if(empty($year) || empty($month) || empty($day))
		$birthDate = "";
	else
		$birthDate = $year.'-'.$month.'-'.$day;    
	
	// Write to tables
	mysql_query("UPDATE persons SET firstName='$firstName', lastName='$lastName', middleName='$middleName', suffix='$suffix', nickname='$nickname', gender='$gender', race='$race', birthDate='$birthDate' WHERE personID = '$id'");
    
	// Access accountID associated with person
    $query = mysql_query("Select accountID from accounts WHERE username = '$user' limit 1");
	$accountID = mysql_result($query, 0);     

    // Access personID associated with account
    $query = mysql_query("Select 0_personID from mappings WHERE accountID = '$accountID' limit 1");
    $pid = mysql_result($query, 0);
    
    // Update accounts table if personID assoicated with account is the same as the current personID
    if($pid == $id){
        mysql_query("UPDATE accounts SET firstName='$firstName', lastName='$lastName', middleName='$middleName', suffix='$suffix' WHERE accountID = '$accountID'");
    }

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("personhome.php");</script>'; 
}
?> 
