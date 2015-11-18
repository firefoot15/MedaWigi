<!-- 	EDIT ALLERGY PAGE
        Receives allergyID and updates single row from table.
 -->

		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}
				
		if(!empty($_GET['id'])){
			$_SESSION['aid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];			
		$aid = $_SESSION['aid'];
		
		$query = mysql_query("Select * from allergies Where allergyID='$aid'"); 
		$row = mysql_fetch_array($query);
		
		$name = $row['allergyName'];
		$type = $row['allergyType'];
		$severity = $row['allergySeverity'];
		?>
<html>
	<head>
		<title>Edit Entry</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<script src="medawigi.js"></script>
	</head>
<div class="top">
  <div id="logo">
    <img src="http://medawigi.no-ip.org/images/logo.png";/>
  </div>
  <div class="sammich">
    <img onclick="menu()" class="sammich" src="http://medawigi.no-ip.org/images/sammich-white.png" />
    <div class="menu">
      <ul id="menu-list">
        <li id="home"><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>">Home</a></li>
        <li id="insurance_contact"><a href="insurance.php">Insurance</a></li>
        <li id="calendar"><a href="calendar.php">Calendar</a></li>
        <li id="journal"><a href="journal.php">Journal</a></li>
        <li id="medications"><a href="medications.php">Medications</a></li>
        <li id="allergies"><a href="allergies.php">Allergies</a></li>
	<li id="immunizations"><a href="immunizations.php">Immunizations</a></li>
	<li id="contacts"><a href="contacts.php">Contacts</a></li>
	<li id="conditions"><a href="conditions.php">Conditions</a></li>
        <li id="contact"><a href="contact.html">Contact us</a></li>
        <li id="editprofile"><a href="editperson.php">Edit Profile</a></li>
        <li id="switch_profile"><a href="myportal.php">Switch Profile</a></li>
        <li id="logout"><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</div>
	<body>
		<h2>EDIT ENTRY</h2>
        <div class="wrapper">
        <table class="page_table"><tr><td></td><td><center>
        <h1>Edit Allergy</h1>                
		<form action="editallergy.php" method="POST">
		<table class="table6" cellpadding="2" cellspacing="5">
			<tr><td>Name: </td>
				<td><input type="text" name="name" value="<?php echo $name; ?>" required="required" maxlength="30"/></td></tr>
			<tr><td>Type: </td>
				<td><select name="type">
					<option value="Indoors"<?php if($type == 'Indoors') echo 'selected="selected"'; ?>>Indoors</option>
					<option value="Outdoors"<?php if($type == 'Outdoors') echo 'selected="selected"'; ?>>Outdoors</option>
					<option value="Food"<?php if($type == 'Food') echo 'selected="selected"'; ?>>Food</option>
					<option value="Other"<?php if($type == 'Other') echo 'selected="selected"'; ?>>Other</option>
				</select></td></tr>
			<tr><td>Severity: </td>
				<td><select name="severity">
					<option value="Mild"<?php if($severity == 'Mild') echo 'selected="selected"'; ?>>Mild</option>
					<option value="Moderate"<?php if($severity == 'Moderate') echo 'selected="selected"'; ?>>Moderate</option>
					<option value="Severe"<?php if($severity == 'Severe') echo 'selected="selected"'; ?>>Severe</option>
				</select></td></tr>
		</table></br>
            
		<table class="table6" cellpadding="2" cellspacing="5">
			<tr><td><a href="allergies.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"></td></tr>
		</table>
		</form>
        </center></td></tr></table>    
    </div></body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$name = mysql_real_escape_string($_POST['name']);
	$type = mysql_real_escape_string($_POST['type']);
	$severity = mysql_real_escape_string($_POST['severity']);

	mysql_query("UPDATE allergies SET allergyName='$name', allergyType='$type', allergySeverity='$severity' WHERE allergyID='$aid'");

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("allergies.php");</script>'; 
}
?>
