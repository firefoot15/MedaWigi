<!-- 	EDIT MEDICATION PAGE
        Receives medicID and updates single row from table.
 -->

		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}
				
		if(!empty($_GET['id'])){
			$_SESSION['mid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];
		$mid = $_SESSION['mid'];
		
		$query = mysql_query("Select * from medications Where medicID='$mid'"); 
		$row = mysql_fetch_array($query);
		
        $name = $row['medicName']; 
		$status = $row['medicStatus'];                
        $rx = $row['medicRxNo'];
        $directions = $row['medicDirections'];
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
        <h1>Edit Medication</h1>             
		<form action="editmedic.php" method="POST">
		<table class="table2">
			<tr><td>Name: </td>
				<td><input type="text" name="name" value="<?php echo $name; ?>" required="required" maxlength="50"/></td></tr>
			<tr><td>Status: </td>
                <td><input type="checkbox" name="status" value="Current"<?php if($status == 'Current') echo 'checked="checked"'; ?>><font size="2"> *Only check if current prescription.</font></td></tr>
            <tr><td>Rx #: </td>
				<td><input type="text" name="rx" value="<?php echo $rx; ?>" maxlength="15"/></td></tr>
			<tr><td>Directions: </td>
				<td><textarea rows="10" cols="50" type="text" name="directions" required="required" maxlength="100"><?php echo $directions; ?></textarea></td></tr>
		</table></br>
        
        <table>
        <th colspan="4"></th>    
            <tr><td></td><td></td>
				<td><a href="medications.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"></td></tr> 
		</table>
		</form>
        </center></td></tr></table>    
    </div></body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$name = mysql_real_escape_string($_POST['name']);
	$rx = mysql_real_escape_string($_POST['rx']);
	$directions = mysql_real_escape_string($_POST['directions']);
    
    if(isset($_POST['status']))
        $status = $_POST['status'];
    else
        $status = 'Expired';

	mysql_query("UPDATE medications SET medicName='$name', medicDirections='$directions', medicRxNo='$rx', medicStatus='$status' WHERE medicID='$mid'");

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("medications.php");</script>'; 
}
?>
