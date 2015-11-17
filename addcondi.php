<!-- 	ADD CONDITION PAGE
        Creates new condition entry.
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
		?>

<html>
	<head>
		<title>New Entry</title>
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
		<h2>NEW ENTRY</h2>
        <div class="wrapper">  
        <table class="page_table"><tr><td></td><td><center>   
        <h1>Add Condition</h1>    
		<form action="addcondi.php" method="POST">            
		<table class="table2">        
			<tr><td>Name: </td>
				<td><input type="text" name="name" required="required" maxlength="30"/></td></tr>                     
			<tr><td>Description: </td>
				<td><textarea rows="10" cols="50" type="text" name="description" required="required" maxlength="350"></textarea></td></tr>
        </table></br>
            
        <table>
        <th colspan="4"></th>    
            <tr><td></td><td></td>
                <td><a href="conditions.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"/></td></tr> 
		</table>
		</form>  
        </center></td></tr></table>    
    </div></body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
	$name = mysql_real_escape_string($_POST['name']);
	$description = mysql_real_escape_string($_POST['description']);
	
	mysql_query("INSERT INTO conditions (condiName, condiDescription, personID) VALUES ('$name','$description','$id')"); 

	Print '<script>alert("Successfully added!");</script>';
	Print '<script>window.location.assign("conditions.php");</script>'; 
}
?>
	