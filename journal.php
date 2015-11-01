		
		<?php
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
			width: 550px;
			font-size: 10px;
		}
	</style>
	<div id="banner"></div>	
	<body><center></br></br>
		<h2>Journal Entries</h2>
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
			mysql_connect("localhost", "root","") or die(mysql_error());
			mysql_select_db("medawigi") or die("Cannot connect to database.");
			$query = mysql_query("Select * from persons WHERE personID = '$id'");
			$row = mysql_fetch_array($query);		

			$apid = $row['apid'];
			$query = mysql_query("Select * from journal WHERE apid = '$apid' ORDER BY journalDate ASC, journalTime ASC");
			while($row = mysql_fetch_array($query))
			{	
				// Output table entries
				Print "<tr>";
					Print '<td align="center">'.$row['journalDate']."</td>";
					Print '<td align="center">'.$row['journalTime']."</td>"; 
					Print '<td align="center">'.$row['journalSubject']."</td>";
					Print '<td align="center"><a href="journalentry.php?id='.$row['journalID'].'"><img src="images/viewButton.png" height="13" width="13"/></a> </td>';
					Print '<td align="center"><a href="editjournal.php?id='.$row['journalID'].'"><img src="images/editButton.png" height="11" width="11"/></a> </td>';
					Print '<td align="center"><a href="#" onclick="myFunction('.$row['journalID'].')"><img src="images/deleteButton.png" height="11" width="11"/></a> </td>';
				Print "</tr>";
			}
			?>
		
		</table></br>
		<table>
			<tr><td colspan="2" align="center">
				<a href="myportal.php"><input type="button" value="Done" class="basic_button"/></a>
				<a href="addjournal.php"><input type="button" value="Add Entry" class="basic_button"/></a>	
		</table>
		<script>
			function myFunction(id)
			{
				var r=confirm("Are you sure you want to delete this record?");
				if (r==true)
				{
					window.location.assign("deletejournal.php?id=" + id);
				}
			}
		</script>		
	</center></body>
</html>
		
