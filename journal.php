<html>
	<head>
		<title>Journal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>		
		
		<?php
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		$user = $_SESSION['user'];	
		
		// id sent from myportal.php
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		if(!empty($_GET['id'])){
			$_SESSION['id'] = $id;}
		?>
		
	<body><center>
		<h3>Journal Entries</h3>
		<table border="1px" width="800px">
			<tr>
				<th>Date</th>
				<th>Time</th>
				<th>Subject</th>
				<th>Content</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>		
			<?php
			// NOT PASSING APID
			mysql_connect("localhost", "root","") or die(mysql_error());
			mysql_select_db("medawigi") or die("Cannot connect to database.");
			$query = mysql_query("Select * from persons WHERE personID = '$id'");
			$row = mysql_fetch_array($query);		

			$apid = $row['apid'];
			$query = mysql_query("Select * from journal WHERE apid = '$apid'");
			while($row = mysql_fetch_array($query))
			{	
				// output table entries
				Print "<tr>";
					Print '<td align="center">'.$row['journalDate']."</td>";
					Print '<td align="center">'.$row['journalTime']."</td>"; 
					Print '<td align="center">'.$row['journalSubject']."</td>";
					Print '<td align="center">'.$row['journalContent']."</td>";
					Print '<td align="center"><a href="editjournal.php?id='. $row['journalID'] .'">Edit</a> </td>';
					Print '<td align="center"><a href="#" onclick="myFunction('. $row['journalID'] .')">Delete</a> </td>';
				Print "</tr>";
			}
			?>
		
		</table>	
		<table border="0" cellpadding="2" cellspacing="5" bgcolor="#202020">
		<th colspan="2">New Entry</th>		
		<form action="addjournal.php" method="POST">
			<tr><td>Date: </td>
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
					<?php for($i=1, $j=date("Y"); $i<=80; $i++, $j--){
						$k=$j%100;
						echo "<option value='$k'>$j</option>";}
					?>
				</select></td></tr>		
			<tr><td>Time: </td>
				<td><select name="hour">
					<?php for($i=12; $i>=1; $i--){
						if($i<10)
							echo "<option value='0$i' selected>0$i</option>";
						else
							echo "<option value='$i' selected>$i</option>";}
					?>
				</select>
				<select name="minute">
					<?php for($i=55; $i>=0; $i-=5){
						if($i<10)
							echo "<option value='0$i' selected>0$i</option>";
						else
							echo "<option value='$i' selected>$i</option>";}
					?>
				</select>
				<select name="period">
					<option value="AM">AM</option>
					<option value="PM">PM</option>
				</select></td></tr>		
			<tr><td>Subject: </td>
				<td><input type="text" name="subject" maxlength="30"/></td></tr>
			<tr><td>Content: </td>
				<td><input type="text" name="content" maxlength="140"/></td></tr>

			<tr><td></td><td><input type="submit" value="Add Entry" class="basic_button"/></td></tr>
		</form>	
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
		
