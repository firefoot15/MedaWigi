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
		<h2>EDIT ENTRY</h2>
        <div class="wrapper">
        <table class="page_table"><tr><td></td><td><center>
        <h1>Edit Allergy</h1>                
		<form action="editallergy.php" method="POST">
		<table class="table1" cellpadding="2" cellspacing="5">
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
            
		<table>
		<th colspan="4"></th>
			<tr><td></td><td></td>
				<td><a href="allergies.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
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