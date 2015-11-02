		
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
		// $subjectArray = $_POST['result'];	
		?>
<html>
	<head>
		<title>Journal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>	
	<style>
		table, th, td{
			width: 550px;
			font-size: 12px;
		}
	</style>	
	<div id="banner"></div>	
	<body><center></br></br>
		<h2>Journal Entries</h2>	
		<table border="0" cellpadding="2" cellspacing="5" bgcolor="#1490CC">
		<th colspan="2">Basic Search</th>
		<form action="searchjournal.php?criteria" method="POST">
			<tr><td>Subject: </td>
				<!--<td><select name="subjectChoice">
					<?php /*for($i=0; $i < count($subjectArray); $i++){							
						echo "<option value='$subjectArray[$i]'>$subjectArray[$i]</option>";}
						*/
					?>				
				</select></td></tr>	-->	
			
				<td><input type="text" name="subjectChoice"/></td></tr>	
			<tr><td>From: </td>
				<td><select name="monthChoice1">
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
				<select name="dayChoice1">
					<?php for($i=31; $i>=1; $i--){
						if($i<10)
							echo "<option value='0$i' selected>$i</option>";
						else
							echo "<option value='$i' selected>$i</option>";}
					?>
				</select>
				<select name="yearChoice1">
					<?php for($i=1, $j=date("Y"); $i<=80; $i++, $j--){
						echo "<option value='$j'>$j</option>";}
					?>
				</select></td></tr>			
			<tr><td>To: </td>
				<td><select name="monthChoice2">
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
				<select name="dayChoice2">
					<?php for($i=31; $i>=1; $i--){
						if($i<10)
							echo "<option value='0$i' selected>$i</option>";
						else
							echo "<option value='$i' selected>$i</option>";}
					?>
				</select>
				<select name="yearChoice2">
					<?php for($i=1, $j=date("Y"); $i<=80; $i++, $j--){
						echo "<option value='$j'>$j</option>";}
					?>
				</select></td></tr>		
			<tr><td></td><td><input type="submit" name="submit" value="Search" class="basic_button"/></td></tr>
			<tr><td></td><td><a href="journal.php"><input type="button" value="Reset" class="basic_button"/></a></td></tr>			
			
			
		</form>		
		</table>
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
	if(isset($_POST['submit'])){
		if(isset($_GET['criteria'])){
			$topic = $_POST['subjectChoice'];
			$month1 = $_POST['monthChoice1'];
			$day1 = $_POST['dayChoice1'];			
			$year1 = $_POST['yearChoice1'];	
			$month2 = $_POST['monthChoice2'];
			$day2 = $_POST['dayChoice2'];			
			$year2 = $_POST['yearChoice2'];	
				
			$start_date = $year1.'-'.$month1.'-'.$day1;
			$end_date = $year2.'-'.$month2.'-'.$day2;
			
			mysql_connect("localhost", "root","") or die(mysql_error());
			mysql_select_db("medawigi") or die("Cannot connect to database.");
			$query = mysql_query("Select * from persons WHERE personID = '$id'");	
			$row = mysql_fetch_array($query);				
			$apid = $row['apid'];			
			$query = mysql_query("Select * from journal WHERE apid = '$apid' AND journalSubject = '$topic'");
			while($row = mysql_fetch_array($query)){
					
				$date = $row['journalDate'];
				$time = $row['journalTime'];
				$subject = $row['journalSubject'];
				$content = $row['journalContent'];
				
				$year = substr($date, 0, 2);
				$month = substr($date, 3, 2);
				$day = substr($date, 6, 2);
				if($year <= date("Y")%100)
					$table_date = '20'.$year.'-'.$month.'-'.$day;	
				else
					$table_date = '19'.$year.'-'.$month.'-'.$day;						

				if(checkRange($start_date, $end_date, $table_date)){

				// Output table entries
				Print "<tr>";
					Print '<td align="center">'.$row['journalDate']."</td>";
					Print '<td align="center">'.$row['journalTime']."</td>"; 
					Print '<td align="center">'.$row['journalSubject']."</td>";
					Print '<td align="center"><a href="journalentry.php?id='.$row['journalID'].'"><img src="images/viewButton.png" height="13" width="13"/></a> </td>';
					Print '<td align="center"><a href="editjournal.php?id='.$row['journalID'].'"><img src="images/editButton.png" height="11" width="11"/></a> </td>';
					Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['journalID'].')"><img src="images/deleteButton.png" height="11" width="11"/></a> </td>';
				Print "</tr>";			
				}
			}
		}
	}
	function checkRange($start_date, $end_date, $table_date){
		// Convert to timestamp
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date);
		$table_ts = strtotime($table_date);
		
		return (($table_ts >= $start_ts) && ($table_ts <= $end_ts));
	}
?>

		

	</center></body>
</html>	