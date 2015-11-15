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
            }
        }  

        // Move eventSubjects into array
        $subjectArray = array();
        for($j = 0; $j < count($idArray); $j++)
        {
            $pid = $idArray[$j];
            $query = mysql_query("Select * from events WHERE personID = '$pid'");
            while($row = mysql_fetch_array($query))
            {
                $flag = true;
                if(empty($subjectArray))
                    array_push($subjectArray, $row['eventSubject']);
                for($i = 0; $i < count($subjectArray); $i++)
                {
                    if($subjectArray[$i] == $row['eventSubject'])
                        $flag = false;
                }
                if($flag)
                    array_push($subjectArray, $row['eventSubject']);              
            }
            sort($subjectArray); 
        }

        // Populate search fields
        // Default values for uninitialized session array
		$person = $id;
		$subject = $subjectArray[0];
        $startYear = (date("Y") - 10)%100;
		$startMonth = 01;
		$startDay = 01;
		$endYear = date("Y");
		$endMonth = date("m");
		$endDay = date("d");

        // Overwrite with values from session array if they exist
        if(isset($_SESSION['sessionArray'])){
            $sessionArray = $_SESSION['sessionArray'];
            
			$person = $sessionArray[0];  
			$subject = $sessionArray[1];
            $startDateSA = $sessionArray[2];
            $endDateSA = $sessionArray[3];
            
            $startYear = substr($startDateSA, 0, 2);
			$startMonth = substr($startDateSA, 3, 2);
			$startDay = substr($startDateSA, 6, 2);
			$endYear = substr($endDateSA, 0, 2);
			$endMonth = substr($endDateSA, 3, 2);
			$endDay = substr($endDateSA, 6, 2);}


        ?>

<html>
	<head>
		<title>Journal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	</head>		
	<body><center></br></br>
		<h2>SEARCH EVENTS</h2>
        <div class="wrapper">    
		<form action="searchjournal.php?criteria" method="POST">
		<table class="table2">
		<th colspan="2">Basic Search</th>
			<tr><td>Person: </td>
				<td><select name="person">
					<?php for($i=0; $i < count($idArray); $i++){
                        if($person == $idArray[$i]){ 
                            echo "<option value='$idArray[$i]' selected>$nameArray[$i]</option>";}
                        else{
                            echo "<option value='$idArray[$i]'>$nameArray[$i]</option>";}}

					?>
				</select></td></tr>            
			<tr><td>Subject: </td>
				<td><select name="subject">
					<?php for($i=0; $i < count($subjectArray); $i++){
                        if($subject == $subjectArray[$i]){ 
                            echo "<option value='$subjectArray[$i]' selected>$subjectArray[$i]</option>";}
                        else{    
                            echo "<option value='$subjectArray[$i]'>$subjectArray[$i]</option>";}}

					?>
				</select></td></tr>
			<tr><td>From: </td>
				<td><select name="startMonth">
					<option value="01"<?php if($startMonth == '01') echo 'selected="selected"'; ?>>January</option>
					<option value="02"<?php if($startMonth == '02') echo 'selected="selected"'; ?>>February</option>
					<option value="03"<?php if($startMonth == '03') echo 'selected="selected"'; ?>>March</option>
					<option value="04"<?php if($startMonth == '04') echo 'selected="selected"'; ?>>April</option>
					<option value="05"<?php if($startMonth == '05') echo 'selected="selected"'; ?>>May</option>
					<option value="06"<?php if($startMonth == '06') echo 'selected="selected"'; ?>>June</option>
					<option value="07"<?php if($startMonth == '07') echo 'selected="selected"'; ?>>July</option>
					<option value="08"<?php if($startMonth == '08') echo 'selected="selected"'; ?>>August</option>
					<option value="09"<?php if($startMonth == '09') echo 'selected="selected"'; ?>>September</option>
					<option value="10"<?php if($startMonth == '10') echo 'selected="selected"'; ?>>October</option>
					<option value="11"<?php if($startMonth == '11') echo 'selected="selected"'; ?>>November</option>
					<option value="12"<?php if($startMonth == '12') echo 'selected="selected"'; ?>>December</option>
				</select>
				<select name="startDay">
					<?php for($i=31; $i>0; $i--){ 
						if($i<10){ 
							if($startDay == $i){
								echo "<option value='0$i' selected>$i</option>";}
							else{
								echo "<option value='0$i'>$i</option>";}}
						else{
							if($startDay == $i){
								echo "<option value='$i' selected>$i</option>";}
							else{
								echo "<option value='$i'>$i</option>";}}}
					?>
				</select>
				<select name="startYear">
					<?php for($i=1, $j=date("Y"); $i<=80; $i++, $j--){
						$k=$j%100;
						if($startYear == $k){
							if($k<10)
								echo "<option value='0$k' selected>$j</option>";
							else
								echo "<option value='$k' selected>$j</option>";}
						else{
							if($k<10)
								echo "<option value='0$k'>$j</option>";
							else
								echo "<option value='$k'>$j</option>";}}
					?>
				</select></td></tr>
			<tr><td>To: </td>
				<td><select name="endMonth">
					<option value="01"<?php if($endMonth == '01') echo 'selected="selected"'; ?>>January</option>
					<option value="02"<?php if($endMonth == '02') echo 'selected="selected"'; ?>>February</option>
					<option value="03"<?php if($endMonth == '03') echo 'selected="selected"'; ?>>March</option>
					<option value="04"<?php if($endMonth == '04') echo 'selected="selected"'; ?>>April</option>
					<option value="05"<?php if($endMonth == '05') echo 'selected="selected"'; ?>>May</option>
					<option value="06"<?php if($endMonth == '06') echo 'selected="selected"'; ?>>June</option>
					<option value="07"<?php if($endMonth == '07') echo 'selected="selected"'; ?>>July</option>
					<option value="08"<?php if($endMonth == '08') echo 'selected="selected"'; ?>>August</option>
					<option value="09"<?php if($endMonth == '09') echo 'selected="selected"'; ?>>September</option>
					<option value="10"<?php if($endMonth == '10') echo 'selected="selected"'; ?>>October</option>
					<option value="11"<?php if($endMonth == '11') echo 'selected="selected"'; ?>>November</option>
					<option value="12"<?php if($endMonth == '12') echo 'selected="selected"'; ?>>December</option>
				</select>
				<select name="endDay">
					<?php for($i=31; $i>0; $i--){ 
						if($i<10){ 
							if($endDay == $i){
								echo "<option value='0$i' selected>$i</option>";}
							else{
								echo "<option value='0$i'>$i</option>";}}
						else{
							if($endDay == $i){
								echo "<option value='$i' selected>$i</option>";} ////////////////////////////////////// change date range?
							else{
								echo "<option value='$i'>$i</option>";}}}
					?>
				</select>
				<select name="endYear">
					<?php for($i=1, $j=date("Y"); $i<=80; $i++, $j--){
						$k=$j%100;
						if($endYear == $k){
							if($k<10)
								echo "<option value='0$k' selected>$j</option>";
							else
								echo "<option value='$k' selected>$j</option>";}
						else{
							if($k<10)
								echo "<option value='0$k'>$j</option>";
							else
								echo "<option value='$k'>$j</option>";}}
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