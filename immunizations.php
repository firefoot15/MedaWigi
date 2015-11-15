<!-- 	IMMUNIZATION PAGE
        Displays all immunizations associated with personID.
        Hidden add immunization form.
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

			<!-- View immunizations form-->
<html>
	<head>
		<title>Immunizations</title>
		<link rel="stylesheet" type="text/css" href="style.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    </head>	
	<body><center></br></br>
		<h2>IMMUNIZATIONS</h2>
        <div class="wrapper">    
        <table class="table3">
			<tr>
				<th>Name</th>
				<th>Date Administered</th>
				<th>Location Administered</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php
            
			// Sort by date
			$query = mysql_query("Select * from immunizations WHERE personID = '$id' ORDER BY immunDate DESC");
			while($row = mysql_fetch_array($query))
			{
				$name = $row['immunName'];
				$date = $row['immunDate'];
				$location = $row['immunLocation'];
                
                $year = substr($date, 0, 4);
                $month = substr($date, 5, 2);
                $day = substr($date, 8, 2);

                $reformatted_date = $month.'-'.$day.'-'.$year;                

				// Output table entries
				Print "<tr>";
					Print '<td align="center">'.$name."</td>";
					Print '<td align="center">'.$reformatted_date."</td>"; 
					Print '<td align="center">'.$location."</td>";
					Print '<td align="center"><a href="editimmun.php?id='.$row['immunID'].'"><img src="images/editButton.png" height="11" width="11"/></a></td>';
					Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['immunID'].')"><img src="images/deleteButton.png" height="11" width="11"/></a> </td>';
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
            
            			<!-- Add immunizations form-->
        <form action="immunizations.php" id="addEntry" name="addEntryFrom" style="display:none;" method="POST">       
		<table class="table1" cellpadding="2" cellspacing="5">
		<th colspan="2">New Entry</th>
			<tr><td>Name: </td>
				<td><input type="text" name="name" required="required" maxlength="30"/></td></tr>
			<tr><td>Date Administered: </td>
				<td><select name="month">
					<option value="01">January</option>
					<option value="02">February</option>
					<option value="03">March</option>
					<option value="04">April</option>
					<option value="05">May</option>
					<option value="06">June</option>
					<option value="07">July</option>
					<option value="08">August</option>
					<option value="09">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
				</select>
				<select name="day">
					<?php for($i=31; $i>=1; $i--){
						if($i<10)
							echo "<option value='0$i' selected>$i</option>";
						else
							echo "<option value='$i' selected>$i</option>";}
					?>
				</select>
				<select name="year">
					<?php for($i=1, $j=date("Y")+5; $i<=40; $i++, $j--){
                        if($j == date("Y"))
                            echo "<option value='$j' selected>$j</option>";
                        else
							echo "<option value='$j'>$j</option>";}
					?>
				</select></td></tr>                    
			<tr><td>Location: </td>
				<td><input type="text" name="location" required="required" maxlength="30"/></td></tr>
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
					window.location.assign("deleteimmun.php?id=" + id);
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
	$month = mysql_real_escape_string($_POST['month']);
	$day = mysql_real_escape_string($_POST['day']);
	$year = mysql_real_escape_string($_POST['year']);
	$location = mysql_real_escape_string($_POST['location']);

	$date = $year.'-'.$month.'-'.$day;
    
	mysql_query("INSERT INTO immunizations (immunName, immunDate, immunLocation, personID) VALUES ('$name','$date','$location','$id')");

	Print '<script>alert("Successfully added!");</script>';
	Print '<script>window.location.assign("immunizations.php");</script>'; 
}
?>