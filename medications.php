<!--    MEDICATIONS PAGE
        Displays a list of all medications associated with personID.
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

            <!-- View medications form-->
<html>
	<head>
		<title>Medications</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>	
	<body><center></br></br>
		<h2>Medications</h2>
        <div class="wrapper">    
        <table class="table3" border="1px">
			<tr>
				<th>Name</th>
				<th>Status</th>                
                <th>Rx #</th>
				<th>Directions</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php
            
			// Sort by status
			$query = mysql_query("Select * from medications WHERE personID = '$id' ORDER BY medicStatus DESC");
			while($row = mysql_fetch_array($query))
			{
				$name = $row['medicName']; 
				$status = $row['medicStatus'];                
                $rx = $row['medicRxNo'];                
                
                // Output table entries
                Print "<tr>";
                    Print '<td align="center">'.$name."</td>";
                    Print '<td align="center">'.$status."</td>";
                    Print '<td align="center">'.$rx."</td>";                 
                    Print '<td align="center"><a href="viewmedic.php?id='.$row['medicID'].'"><img src="images/viewButton.png" height="13" width="13"/></a></td>';                
                    Print '<td align="center"><a href="editmedic.php?id='.$row['medicID'].'"><img src="images/editButton.png" height="11" width="11"/></a></td>';
                    Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['medicID'].')"><img src="images/deleteButton.png" height="11" width="11"/></a></td>';
                Print "</tr>";                   
            }
            ?>

		</table></br>
    
		<table>
		<th colspan="2"></th>
            <tr><td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Done" class="basic_button"/></a></td>
                <td><a href="addmedic.php"><input type="button" value="Add Entry" class="basic_button"/></a></td></tr>
        </table>

		<script>
			function deleteFunction(id)
			{
				var r=confirm("Are you sure you want to delete this record?");
				if (r==true)
				{
					window.location.assign("deletemedic.php?id=" + id);
				}
			}
		</script>
    </div></center></body>
</html>