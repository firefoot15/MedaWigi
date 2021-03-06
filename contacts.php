<!-- 	CONTACTS PAGE
        Displays all contacts associated with personID.
        Hidden add contact form.
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

        // Access accountID associated with person
        $query = mysql_query("Select accountID from accounts WHERE username = '$user' limit 1");
        $accountID = mysql_result($query, 0);     

        // Access personID associated with account to be used in h1
        $query = mysql_query("Select 0_personID from mappings WHERE accountID = '$accountID' limit 1");
        $pid = mysql_result($query, 0);

        // Use personID to access nickname in persons table to be used in h1
		$query = mysql_query("Select nickname from persons WHERE personID = '$id' limit 1");
		$nickname = mysql_result($query, 0); 
		?>

			<!-- View contacts form-->
<html>
	<head>
		<title>Contacts</title>
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
		<h2>CONTACTS</h2>
        <div class="wrapper">   
        <table class="page_table"><tr><td></td><td><center>    
        <h1><?php if($pid == $id)echo 'My'; else echo htmlspecialchars($nickname)."'s";?> Contacts</h1>    
        <table class="table3">
			<tr>
				<th align="left">Name</th>
				<th align="left">Relationship</th>
				<th align="left">Phone</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php
			
			$query = mysql_query("Select * from contacts WHERE personID = '$id'");
			while($row = mysql_fetch_array($query))
			{			
				$name = $row['contactName'];
				$relationship = $row['contactRelationship'];
				$phone = $row['contactPhone'];

				// Output table entries
				Print "<tr>";
					Print '<td>'.$name."</td>";
					Print '<td>'.$relationship."</td>"; 
					Print '<td>'.$phone."</td>";
					Print '<td align="center"><a href="editcontact.php?id='.$row['contactID'].'"><img src="images/editButton.png" height="14" width="14"/></a></td>';
					Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['contactID'].')"><img src="images/deleteButton.png" height="14" width="14"/></a></td>';
				Print "</tr>";
			}
			?>
        </table></br>    
            
        <table class="table6" cellpadding="2" cellspacing="5">
            <tr><td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Done" class="basic_button"/></a></td>
                <td><input type="submit" name="addEntryButton" value="Add Entry" onclick="showAddEntryForm()" class="basic_button"/></td></tr> 
		</table></br> 
            
            			<!-- Add contacts form-->
        <form action="contacts.php" id="addEntry" name="addEntryFrom" style="display:none;" method="POST">       
		<table class="table6" cellpadding="2" cellspacing="5">
		<th colspan="2">New Entry</th>
			<tr><td>Name: </td>
				<td><input type="text" name="name" required="required" maxlength="30"/></td></tr>
			<tr><td>Relationship: </td>
				<td><input type="text" name="relationship" required="required" maxlength="30"/></td></tr>
			<tr><td>Phone: </td>
				<td><input type="text" name="areaCode" required="required" maxlength="3" size="3"/>-
                    <input type="text" name="exchangeCode" required="required" maxlength="3" size="3"/>-
                    <input type="text" name="subscriberNumber" required="required" maxlength="4" size="4"/></td></tr>
        </table></br>
    
        <table class="table6" cellpadding="2" cellspacing="5">      
            <tr><td><input type="submit" name="cancelAddEntry" value="Cancel" onclick="hideAddEntryForm()" class="basic_button"/></td>
                <td><input type="submit" name="submitAddEntry" value="Submit" onclick="submitAddEntryForm()" class="basic_button"/></td></tr>  
		</table>
        </form>
    </center></td></tr></table>            

		<script>
			function deleteFunction(id)
			{
				var r=confirm("Are you sure you want to delete this record?");
				if (r==true)
				{
					window.location.assign("deletecontact.php?id=" + id);
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
    </div></body>
</html>

<?php
if (isset($_POST['submitAddEntry'])) {
	$name = mysql_real_escape_string($_POST['name']);
	$relationship = mysql_real_escape_string($_POST['relationship']);
	$areaCode = mysql_real_escape_string($_POST['areaCode']);
	$exchangeCode = mysql_real_escape_string($_POST['exchangeCode']);
	$subscriberNumber = mysql_real_escape_string($_POST['subscriberNumber']); 
    
    $bool = true;
    
	// Validate phone number
	if(strlen($areaCode) < 3 || !ctype_digit($areaCode) || strlen($exchangeCode) < 3 || !ctype_digit($exchangeCode) || strlen($subscriberNumber) < 4 || !ctype_digit($subscriberNumber))
	{
		$bool = false;
		Print '<script>alert("Invalid phone number!");</script>'; 
		Print '<script>window.location.assign("contacts.php");</script>';
	}

	if($bool) 
    {
        $phone = $areaCode.'-'.$exchangeCode.'-'.$subscriberNumber;
        
        mysql_query("INSERT INTO contacts (contactName, contactRelationship, contactPhone, personID) VALUES ('$name','$relationship','$phone','$id')");

        Print '<script>alert("Successfully added!");</script>';
        Print '<script>window.location.assign("contacts.php");</script>'; 
    }    
}
?>
