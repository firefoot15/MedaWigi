<!-- 	EDIT IMMUNIZATION PAGE
        Receives immunID and updates single row from table.
 -->

		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}
				
		if(!empty($_GET['id'])){
			$_SESSION['iid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];
		$iid = $_SESSION['iid'];
		
		$query = mysql_query("Select * from immunizations Where immunID='$iid'"); 
		$row = mysql_fetch_array($query);
		
		$name = $row['immunName'];
		$date = $row['immunDate'];
		$location = $row['immunLocation'];

		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8, 2);
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
		<form action="editimmun.php" method="POST">
        <table class="page_table"><tr><td></td><td><center>
        <h1>Edit Immunization</h1>                      
		<table class="table6" cellpadding="2" cellspacing="5">
			<tr><td>Name: </td>
				<td><input type="text" name="name" value="<?php echo $name; ?>" required="required" maxlength="30"/></td></tr>
			<tr><td>Date: </td>
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
					<?php for($i=31; $i>0; $i--){ 
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
					<?php for($i=1, $j=date("Y")+5; $i<=40; $i++, $j--){
						if($year == $j){
				            echo "<option value='$j' selected>$j</option>";}
						else{
				            echo "<option value='$j'>$j</option>";}}
					?>
				</select></td></tr>            
			<tr><td>Location: </td>
				<td><input type="text" name="location" value="<?php echo $location; ?>" required="required" maxlength="30"/></td></tr>            
        </table></br>
            
		<table class="table6" cellpadding="2" cellspacing="5">
			<tr><td><a href="immunizations.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"></td></tr> 	
		</table>
		</form>
        </center></td></tr></table>    
    </div></body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$name = mysql_real_escape_string($_POST['name']);
	$month = mysql_real_escape_string($_POST['month']);
	$day = mysql_real_escape_string($_POST['day']);
	$year = mysql_real_escape_string($_POST['year']);
	$location = mysql_real_escape_string($_POST['location']);

    $date = $year.'-'.$month.'-'.$day;

	mysql_query("UPDATE immunizations SET immunName='$name', immunDate='$date', immunLocation='$location' WHERE immunID='$iid'");

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("immunizations.php");</script>'; 
}
?>
