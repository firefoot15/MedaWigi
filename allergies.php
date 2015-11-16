<!-- 	ALLERGIES PAGE
        Displays all allergies associated with personID.
        Hidden add allergy form.
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

			<!-- View allergies form-->
<html>
	<head>
		<title>Allergies</title>
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
	<body><center></br></br>
		<h2>ALLERGIES</h2>
        <div class="wrapper">    
        <table class="table3">
        <th2 colspan="5">Allergies</th2>
			<tr>
				<th align="left">Name</th>
				<th align="left">Type</th>
				<th align="left">Severity</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php
			
			// Sort by type
			$query = mysql_query("Select * from allergies WHERE personID = '$id' ORDER BY allergyType ASC");
			while($row = mysql_fetch_array($query))
			{			
				$name = $row['allergyName'];
				$type = $row['allergyType'];
				$severity = $row['allergySeverity'];

				// Output table entries
				Print "<tr>";
					Print '<td>'.$name."</td>";
					Print '<td>'.$type."</td>"; 
					Print '<td>'.$severity."</td>";
					Print '<td align="center"><a href="editallergy.php?id='.$row['allergyID'].'"><img src="images/editButton.png" height="14" width="14"/></a></td>';
					Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['allergyID'].')"><img src="images/deleteButton.png" height="14" width="14"/></a> </td>';
				Print "</tr>";
			}
			?>
        </table></br>    
            
        <table>
		<th colspan="4"></th>
            <tr><td></td><td></td>
                <td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Done" class="basic_button"/></a></td>
                <td><input type="submit" name="addEntryButton" value="Add Entry" onclick="showAddEntryForm()" class="basic_button"/></td></tr> 
		</table></br> 
            
            			<!-- Add allergies form-->
        <form action="allergies.php" id="addEntry" name="addEntryFrom" style="display:none;" method="POST">       
		<table class="table1" cellpadding="2" cellspacing="5">
		<th colspan="2">New Entry</th>
			<tr><td>Name: </td>
				<td><input type="text" name="name" required="required" maxlength="30"/></td></tr>
			<tr><td>Type: </td>
				<td><select name="type">
					<option value="Indoors">Indoors</option>
					<option value="Outdoors">Outdoors</option>
					<option value="Food">Food</option>
					<option value="Other">Other</option>
				</select></td></tr>
			<tr><td>Severity: </td>
				<td><select name="severity">
					<option value="Mild">Mild</option>
					<option value="Moderate">Moderate</option>
					<option value="Severe">Severe</option>
				</select></td></tr>
        </table></br>  
    
        <table>    
        <th colspan="4"></th>    
            <tr><td></td><td></td>
                <td><input type="submit" name="cancelAddEntry" value="Cancel" onclick="hideAddEntryForm()" class="basic_button"/></td>
                <td><input type="submit" name="submitAddEntry" value="Submit" onclick="submitAddEntryForm()" class="basic_button"/></td></tr>  
		</table>
        </form>

		<script>
			function deleteFunction(id)
			{
				var r=confirm("Are you sure you want to delete this record?");
				if (r==true)
				{
					window.location.assign("deleteallergy.php?id=" + id);
				}
			}
            function showAddEntryForm()
            {
                document.getElementById('addEntry').style.display="block";
            }
            function hideAddEntryForm()
            {
                document.getElementById('addEntry').style.display="none";
            }            
		</script>
    </div></center></body>
</html>

<?php
if (isset($_POST['submitAddEntry'])) {
	$name = mysql_real_escape_string($_POST['name']);
	$type = mysql_real_escape_string($_POST['type']);
	$severity = mysql_real_escape_string($_POST['severity']);

	mysql_query("INSERT INTO allergies (allergyName, allergyType, allergySeverity, personID) VALUES ('$name','$type','$severity','$id')");

	Print '<script>alert("Successfully added!");</script>';
	Print '<script>window.location.assign("allergies.php");</script>'; 
}
?>