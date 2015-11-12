<!--    JOURNAL PAGE
		Displays all journal entries assoicated with an account.
 -->
		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

        /*  This is necessary even though journal entries are accessed via accountID
            because the journal button is still located on the home page   */
		if($_SESSION['id']){ }
		else{
			header("location:myportal.php");}

		$user = $_SESSION['user'];
		$id = $_SESSION['id'];
		?>
<html>
	<head>
		<title>Journal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>	
	<body><center></br></br>
		<h2>Journal Entries</h2>
        <div class="wrapper">
            
		<table>
		<th colspan="3"></th>
			<tr><td><a href="addjournal.php"><input type="button" value="Add Entry" class="basic_button2"/></a></td>
				<td></td><td></td><td><a href="searchjournal.php"><input type="button" value="Set Search Criteria" class="basic_button2"/></a></td>
				<td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Done" class="basic_button2"/></a></td></tr>
        </table></br>
            
		<table class="table3" border="1px">
			<tr>
				<th>Date</th>
				<th>Time</th>
                <th>Person</th>
				<th>Subject</th>
				<th>Content</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php
            
            // Use username to access accountID in accounts table
            $query = mysql_query("Select accountID from accounts WHERE username = '$user' limit 1");
            $accountID = mysql_result($query, 0);   

            // Use accountID to access personIDs in mappings table      
            $query = mysql_query("Select * from mappings WHERE accountID = '$accountID'");
            $row = mysql_fetch_array($query);
            
            // Move personIDs to array    
            $idArray = array();  
            for($i = 0; $i < 10; $i++)
            {
                $colName = $i.'_personID';
                $pid = abs($row[$colName]);
                if($pid != 0)
                    array_push($idArray, $pid);
            }              
            
            for($j = 0; $j < count($idArray); $j++)
            {
                $pid = $idArray[$j];
                
                // Use personID from journal table to access nickname in persons table
                $query = mysql_query("Select nickname from persons WHERE personID = '$pid' limit 1");
                $person = mysql_result($query, 0);
                
                $query = mysql_query("Select * from events WHERE personID = '$pid'");
                while($row = mysql_fetch_array($query))
                {
                    $date = $row['eventDate'];
				    $time = $row['eventTime'];
				    $subject = $row['eventSubject'];
		
				    $year = substr($date, 0, 2);
				    $month = substr($date, 3, 2);
				    $day = substr($date, 6, 2);

                    $reformatted_date = $month.'-'.$day.'-'.$year;    
                    
                    // Output table entries
                    Print "<tr>";
                        Print '<td align="center">'.$reformatted_date."</td>";
                        Print '<td align="center">'.$time."</td>"; 
                        Print '<td align="center">'.$person."</td>";
                        Print '<td align="center">'.$subject."</td>";
                        Print '<td align="center"><a href="viewjournal.php?id='.$row['eventID'].'"><img src="images/viewButton.png" height="13" width="13"/></a> </td>';
                        Print '<td align="center"><a href="editjournal.php?id='.$row['eventID'].'"><img src="images/editButton.png" height="11" width="11"/></a> </td>';
                        Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['eventID'].')"><img src="images/deleteButton.png" height="11" width="11"/></a> </td>';
                    Print "</tr>";                   
                }
            }
            ?>

		</table></br>
		<script>
			function deleteFunction(id)
			{
				var r=confirm("Are you sure you want to delete this record?");
				if (r==true)
				{
					window.location.assign("deletejournal.php?id=" + id);
				}
			}
		</script>
    </div></center></body>
</html>