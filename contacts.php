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
		?>

			<!-- View contacts form-->
<html>
	<head>
		<title>Contacts</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>	
	<body><center></br></br>
		<h2>Contacts</h2>
        <div class="wrapper">    
        <table class="table3" border="1px">
			<tr>
				<th>Name</th>
				<th>Relationship</th>
				<th>Phone</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php
			
			// Sort by type
			$query = mysql_query("Select * from contacts WHERE personID = '$id'");
			while($row = mysql_fetch_array($query))
			{			
				$name = $row['contactName'];
				$relationship = $row['contactRelationship'];
				$phone = $row['contactPhone'];

				// Output table entries
				Print "<tr>";
					Print '<td align="center">'.$name."</td>";
					Print '<td align="center">'.$relationship."</td>"; 
					Print '<td align="center">'.$phone."</td>";
					Print '<td align="center"><a href="editcontact.php?id='.$row['contactID'].'"><img src="images/editButton.png" height="11" width="11"/></a></td>';
					Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['contactID'].')"><img src="images/deleteButton.png" height="11" width="11"/></a> </td>';
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
            
            			<!-- Add contacts form-->
        <form action="contacts.php" id="addEntry" name="addEntryFrom" style="display:none;" method="POST">       
		<table class="table1" cellpadding="2" cellspacing="5">
		<th colspan="2">New Entry</th>
			<tr><td>Name: </td>
				<td><input type="text" name="name" required="required" maxlength="30"/></td></tr>
			<tr><td>Relationship: </td>
				<td><input type="text" name="relationship" required="required" maxlength="30"/></td></tr>
			<tr><td>Phone: </td>
				<td><input type="text" name="areaCode" required="required" maxlength="3" size="3"/>
                    <input type="text" name="exchangeCode" required="required" maxlength="3" size="3"/>
                    <input type="text" name="subscriberNumber" required="required" maxlength="4" size="4"/></td></tr>
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
    </div></center></body>
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