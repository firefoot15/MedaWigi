		
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
	</head>	
	<div id="banner"></div>	
	<body><center></br></br>
		<h2>Allergies</h2>		
        <div class="wrapper">    
        <table class="table3" border="1px">
			<tr>
				<th>Name</th>
				<th>Type</th>
				<th>Severity</th>
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
					Print '<td align="center">'.$name."</td>";
					Print '<td align="center">'.$type."</td>"; 
					Print '<td align="center">'.$severity."</td>";
					Print '<td align="center"><a href="editallergy.php?id='.$row['allergyID'].'"><img src="images/editButton.png" height="11" width="11"/></a></td>';
					Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['allergyID'].')"><img src="images/deleteButton.png" height="11" width="11"/></a> </td>';
				Print "</tr>";
			}	
			?>
        </table></br>    
            
        <table>
		<th colspan="4"></th>		
            <tr><td></td><td></td>			
                <td><a href="personhome.php"><input type="button" value="Done" class="basic_button"/></a></td>
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