		<!-- --------------------------------------------------------------------- -->	
		<!-- need if statement in edit/delete/view to specify which page to return -->
		<!-- --------------------------------------------------------------------- -->		
		
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

        // Use username to access accountID in accounts table            
        $query = mysql_query("Select accountID from accounts WHERE username = '$user' limit 1");
        $accountID = mysql_result($query, 0);   

		// Use accountID to access personIDs in mappings table      
        $query = mysql_query("Select * from mappings WHERE accountID = '$accountID'");
		$row = mysql_fetch_array($query);
            
        // Move personIDs to array    
        $idArray = array();  
        $nameArray = array();
        for($i = 0; $i < 10; $i++)
        {
            $colName = $i.'_personID';
            $pid = abs($row[$colName]);
            if($pid != 0)
            {
                array_push($idArray, $pid);
                $query = mysql_query("Select nickname from persons WHERE personID = '$pid' limit 1");
                $nickname = mysql_result($query, 0);                 
                array_push($nameArray, $nickname);
                sort($nameArray);
            }  
        }  

        // Move journalSubjects into array
		$subjectArray = array();					
		$query = mysql_query("Select * from journal WHERE accountID = '$accountID'");
		while($row = mysql_fetch_array($query))
		{
			$flag = true;
			if(empty($subjectArray))
				array_push($subjectArray, $row['journalSubject']);
			for($i = 0; $i < count($subjectArray); $i++){
				if($subjectArray[$i] == $row['journalSubject'])
					$flag = false;}
			if($flag)
				array_push($subjectArray, $row['journalSubject']);		
			sort($subjectArray);
		}
		?>

<html>
	<head>
		<title>Journal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>		
	<body><center></br></br>
		<h2>Search Journal</h2>	
        <div class="wrapper">    
		<form action="searchjournal.php?criteria" method="POST">		
		<table class="table2">
		<th colspan="2">Basic Search</th>
			<tr><td>Person: </td>
				<td><select name="personChoice">
					<?php for($i=0; $i < count($idArray); $i++){							
						echo "<option value='$idArray[$i]'>$nameArray[$i]</option>";}
						
					?>				
				</select></td></tr>            
			<tr><td>Subject: </td>
				<td><select name="subjectChoice">
					<?php for($i=0; $i < count($subjectArray); $i++){							
						echo "<option value='$subjectArray[$i]'>$subjectArray[$i]</option>";}
						
					?>				
				</select></td></tr>
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
		</table></br>		
            
        <table>
        <th colspan="4"></th>    
            <tr><td></td><td></td>
				<td><a href="journal.php"><input type="button" value="Done" class="basic_button"/></a></td>
				<td><input type="submit" name="submit" value="Search" class="basic_button"/></td></tr>
		</table>
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
	
<?php	
	if(isset($_POST['submit'])){
		if(isset($_GET['criteria'])){
			$person = $_POST['personChoice'];            
			$subject = $_POST['subjectChoice'];
			$month1 = $_POST['monthChoice1'];
			$day1 = $_POST['dayChoice1'];			
			$year1 = $_POST['yearChoice1'];	
			$month2 = $_POST['monthChoice2'];
			$day2 = $_POST['dayChoice2'];			
			$year2 = $_POST['yearChoice2'];	
				
			$start_date = $year1.'-'.$month1.'-'.$day1;
			$end_date = $year2.'-'.$month2.'-'.$day2;
            
			$query = mysql_query("Select * from journal WHERE accountID = '$accountID' AND journalSubject = '$subject' AND personID = '$person' ORDER BY journalDate ASC, journalTime ASC");
            if(mysql_num_rows($query) == 0){
                Print 'There are no matches for this search.';
            }
            else{
            ?>

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

                while($row = mysql_fetch_array($query)){
                
				    $date = $row['journalDate'];
                    $time = $row['journalTime'];
				
				    $year = substr($date, 0, 2);
				    $month = substr($date, 3, 2);
				    $day = substr($date, 6, 2);
				
				    $reformatted_date = $month.'-'.$day.'-'.$year;
                
                    // Use personID from journal table to access nickname in persons table
                    $pid = $row['personID'];
                    $query2 = mysql_query("Select nickname from persons WHERE personID = '$pid' limit 1");
                    $person = mysql_result($query2, 0);                    
				
				    // Put date in a format checkRange() can use
                    if($year <= date("Y")%100)
					   $table_date = '20'.$year.'-'.$month.'-'.$day;	
				    else
					   $table_date = '19'.$year.'-'.$month.'-'.$day;						

				    if(checkRange($start_date, $end_date, $table_date)){

				// Output table entries
				Print "<tr>";
					Print '<td align="center">'.$reformatted_date."</td>";
					Print '<td align="center">'.$time."</td>"; 
                    Print '<td align="center">'.$person."</td>";///                    
					Print '<td align="center">'.$subject."</td>";
					Print '<td align="center"><a href="viewjournal.php?id='.$row['journalID'].'"><img src="images/viewButton.png" height="13" width="13"/></a> </td>';
					Print '<td align="center"><a href="editjournal.php?id='.$row['journalID'].'"><img src="images/editButton.png" height="11" width="11"/></a> </td>';
					Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['journalID'].')"><img src="images/deleteButton.png" height="11" width="11"/></a> </td>';
				Print "</tr>";		
				    }
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
            
        </table>
    </div></center></body>
</html>	