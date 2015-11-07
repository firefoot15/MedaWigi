<!-- 	EDIT PERSON PAGE
		Edit form for individual profiles
		General input validation, no account information
		Link to avatar page
		Only updates persons table
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
		
		$year = substr($birthDate, 0, 2);
		$month = substr($birthDate, 3, 2);
		$day = substr($birthDate, 6, 2);
		?>
<html>
	<head>
		<title>Edit Person Page</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>	
	<div id="banner"></div>		
	<body><center></br></br>
		<h2>Edit Person</h2>
        <div class="wrapper">    
		<table class="table1" cellpadding="2" cellspacing="5">
		<th colspan="2">Edit Person</th>
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
					<option value=""<?php if($race == '') echo 'selected="selected"'; ?>></option>	                    
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
						$k=$j%100;
						if(empty($year)){
							if($i == 80){
								echo "<option value='' selected></option>";}
							elseif($k<10){
								echo "<option value='0$k'>$j</option>";}	
							else{
								echo "<option value='$k'>$j</option>";}}
						else{
							if($k<10){
								if($year == $k){
									echo "<option value='0$k' selected>$j</option>";}
								else{
									echo "<option value='0$k'>$j</option>";}}
							else{
								if($year == $k){
									echo "<option value='$k' selected>$j</option>";}
								else{
									echo "<option value='$k'>$j</option>";}}}}
					?>
				</select></td></tr>
			<tr><td></td></tr>
            <tr><td></td>
				<td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Cancel" class="basic_button"/></a>
				<input type="submit" value="Submit" class="basic_button"/></td></tr> 
		</form>
		</table></br></br>		
			<a href="avatar.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Change Avatar" class="basic_button"/></a></br></br>
    </div></center></body>
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

	$birthDate = $year.'-'.$month.'-'.$day;
	$id = $_SESSION['id'];
	
	// Write to tables
	mysql_query("UPDATE persons SET firstName='$firstName', lastName='$lastName', middleName='$middleName', suffix='$suffix', nickname='$nickname', gender='$gender', race='$race', birthDate='$birthDate' WHERE personID = '$id'");
    
	$query = mysql_query("Select accountID from accounts WHERE username = '$user' limit 1");
	$accountID = mysql_result($query, 0);     

    $query = mysql_query("Select 0_personID from mappings WHERE accountID = '$accountID' limit 1");
    $pid = mysql_result($query, 0);
    
    if($pid == $id){
        mysql_query("UPDATE accounts SET firstName='$firstName', lastName='$lastName', middleName='$middleName', suffix='$suffix' WHERE accountID = '$accountID'");
    }

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("personhome.php");</script>'; 
}
?> 