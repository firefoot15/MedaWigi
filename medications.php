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
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	</head>	
	<body><center></br></br>
		<h2>MEDICATIONS</h2>
        <div class="wrapper">    
        <table class="table3">
			<tr>
				<th align="left">Name</th>
				<th align="left">Status</th>                
                <th align="left">Rx #</th>
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
                    Print '<td>'.$name."</td>";
                    Print '<td>'.$status."</td>";
                    Print '<td>'.$rx."</td>";                 
                    Print '<td align="center"><a href="viewmedic.php?id='.$row['medicID'].'"><img src="images/viewButton.png" height="17" width="17"/></a></td>';                
                    Print '<td align="center"><a href="editmedic.php?id='.$row['medicID'].'"><img src="images/editButton.png" height="14" width="14"/></a></td>';
                    Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['medicID'].')"><img src="images/deleteButton.png" height="14" width="14"/></a></td>';
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