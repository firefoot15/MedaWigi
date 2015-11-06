		
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
		<title>Journal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>	
	<style>
		table, th, td{
			width: 500px;
			font-size: 12px;
		}
	</style>
	<div id="banner"></div>	
	<body><center></br></br>
		<h2>Journal Entries</h2>
        <div class="wrapper">
		<form action="searchjournal.php" method="POST">		
		<table border="0" cellpadding="2" cellspacing="5" bgcolor="#1490CC">
		<th colspan="4"></th>
			<tr><td></td>
				<td><a href="addjournal.php"><input type="button" value="Add Entry" class="basic_button2"/></a></td>
				<td></td><td></td><td><a href="searchjournal.php"><input type="button" value="Set Search Criteria" class="basic_button2"/></a></td>				
				<td><a href="personhome.php"><input type="button" value="Done" class="basic_button2"/></a></td></tr>
		</table>		
		<table border="1px" font color="#202020">
			<tr>
				<th>Date</th>
				<th>Time</th>
				<th>Subject</th>
				<th>Content</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>				
			<?php
			$query = mysql_query("Select * from persons WHERE personID = '$id'");	
			$row = mysql_fetch_array($query);	
			$count = mysql_num_rows($query);						
			$apid = $row['apid'];		
			
			// Sort by date & time
			$query = mysql_query("Select * from journal WHERE apid = '$apid' ORDER BY journalDate ASC, journalTime ASC");
			while($row = mysql_fetch_array($query))
			{			
				$date = $row['journalDate'];
				$time = $row['journalTime'];
				$subject = $row['journalSubject'];
		
				$year = substr($date, 0, 2);
				$month = substr($date, 3, 2);
				$day = substr($date, 6, 2);		
		
				$reformatted_date = $month.'-'.$day.'-'.$year;
		
				// Output table entries
				Print "<tr>";
					Print '<td align="center">'.$reformatted_date."</td>";
					Print '<td align="center">'.$time."</td>"; 
					Print '<td align="center">'.$subject."</td>";
					Print '<td align="center"><a href="viewjournal.php?id='.$row['journalID'].'"><img src="images/viewButton.png" height="13" width="13"/></a> </td>';
					Print '<td align="center"><a href="editjournal.php?id='.$row['journalID'].'"><img src="images/editButton.png" height="11" width="11"/></a> </td>';
					Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['journalID'].')"><img src="images/deleteButton.png" height="11" width="11"/></a> </td>';
				Print "</tr>";
			}	
			?>

		</table></br>
		</form>			
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