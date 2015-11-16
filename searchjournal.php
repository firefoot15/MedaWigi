<!--    SEARCH JOURNAL PAGE
        Returns results of search.
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

	if(isset($_POST['submit'])){
        
        
        
        
        
        
        
        ?>

<html>
	<head>
		<title>Journal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	</head>		
	<body><center></br></br>
		<h2>VIEW EVENTS</h2>
        <div class="wrapper">    
		<form action="searchjournal.php" method="POST">
		<table class="table2">
		<th colspan="2">Search Results</th>
	
            
            
            
            
            
            
        
            
            
		</table></br>
            
        <table>
        <th colspan="7"></th>    
            <tr><td><a href="journal.php"><input type="button" value="Done" class="basic_button"/></a></td></tr>
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
			$pid = $_POST['person'];            
			$subject = $_POST['subject'];
			$startMonth = $_POST['startMonth'];
			$startDay = $_POST['startDay'];
			$startYear = $_POST['startYear'];
			$endMonth = $_POST['endMonth'];
			$endDay = $_POST['endDay'];
			$endYear = $_POST['endYear'];

            // Reformat for session array
            $startDateSA = $startYear.'-'.$startMonth.'-'.$startDay;
            $endDateSA = $endYear.'-'.$endMonth.'-'.$endDay;
                
            // Preserve search variables
            $sessionArray = array($pid, $subject, $startDateSA, $endDateSA);
            $_SESSION['sessionArray'] = $sessionArray;
            
            // Reformat for checkRange() function
            if($startYear > date("Y")%100)
                $startYear = '19'.$startYear;
            else
                $startYear = '20'.$startYear;
            
            if($endYear > date("Y")%100)
                $endYear = '19'.$endYear;
            else
                $endYear = '20'.$endYear;
                
			$startDateCR = $startYear.'-'.$startMonth.'-'.$startDay;
			$endDateCR = $endYear.'-'.$endMonth.'-'.$endDay;

            // Sort output by date
            $query = mysql_query("Select * from events WHERE personID = '$pid' AND eventSubject = '$subject' ORDER BY eventDate ASC, eventTime ASC");
            if(mysql_num_rows($query) == 0){
                Print 'There are no matches for this search.';}
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
                
				    $date = $row['eventDate'];
                    $time = $row['eventTime'];
				
				    $year = substr($date, 0, 2);
				    $month = substr($date, 3, 2);
				    $day = substr($date, 6, 2);
				
				    $reformatted_date = $month.'-'.$day.'-'.$year;
                
                    // Use personID from event table to access nickname in persons table
                    $query2 = mysql_query("Select nickname from persons WHERE personID = '$pid' limit 1");
                    $person = mysql_result($query2, 0);       
				
				    // Reformat for checkRange() function
                    if($year > date("Y")%100)
					   $tableDateCR = '19'.$year.'-'.$month.'-'.$day;
				    else
					   $tableDateCR = '20'.$year.'-'.$month.'-'.$day;

				    if(checkRange($startDateCR, $endDateCR, $tableDateCR)){

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
            }
		}
	}
	function checkRange($startDateCR, $endDateCR, $tableDateCR){
		
        // Convert to timestamp
		$start_ts = strtotime($startDateCR);
		$end_ts = strtotime($endDateCR);
		$table_ts = strtotime($tableDateCR);
		
		return (($table_ts >= $start_ts) && ($table_ts <= $end_ts));
	}
?>
            
        </table>
    </div></center></body>
</html>	