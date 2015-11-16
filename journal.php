<!--    JOURNAL PAGE
        Users set search criteria for events. 
        Returns entries for all persons attached to account.
        Includes CRUD functions.
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

        $sessionFlag = false;   /////////////////////////////////////////////////////////////////////////////////////////
// if search is refreshed from same page, both search and previous appear, clear session variable onClick?

        // Populate search fields
        // Default values for uninitialized session array
		$person = $id;
		$subject = $subjectArray[0];
        $startYear = (date("Y") - 10);
		$startMonth = 01;
		$startDay = 01;
		$endYear = date("Y");
		$endMonth = 01;
		$endDay = 01;

        // Overwrite with values from session array if they exist
        if(isset($_SESSION['sessionArray']))
        {
            $sessionFlag = true;
            $sessionArray = $_SESSION['sessionArray'];
            print_r($sessionArray);
            
			$person = $sessionArray[0];  
			$subject = $sessionArray[1];
            $startDate = $sessionArray[2];
            $endDate = $sessionArray[3];
            
            $startYear = substr($startDate, 0, 4);
			$startMonth = substr($startDate, 5, 2);
			$startDay = substr($startDate, 8, 2);
			$endYear = substr($endDate, 0, 4);
			$endMonth = substr($endDate, 5, 2);
			$endDay = substr($endDate, 8, 2);
        }

// Search form
?>
<html>
	<head>
		<title>Journal</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<script src="medawigi.js"></script>
</head>
<div class="top">
  <div id="logo">
    <img />
    
  </div>
  <div class="sammich">
    <img onclick="menu()" class="sammich" src="https://cdn2.iconfinder.com/data/icons/menu-elements/154/round-border-menu-bar-128.png" />



    <div class="menu">
      <ul id="menu-list">
        <br>
        <li id="home"><a href="index.php">Home</a></li>
        <br>
        <li id="contact"><a href="contact.html">Contact us</a></li>
        <br>
      </ul>
    </div>
  </div>

</div>
	<body><center></br></br>
		<h2>SEARCH EVENTS</h2>
        <div class="wrapper">    
		<form action="journal.php" method="POST">
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
						if($startYear == $j){
				            echo "<option value='$j' selected>$j</option>";}
						else{
				            echo "<option value='$j'>$j</option>";}}
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
						if($endYear == $j){
				            echo "<option value='$j' selected>$j</option>";}
						else{
				            echo "<option value='$j'>$j</option>";}}
					?>
				</select></td></tr>
		</table></br>
            
        <input type="submit" name="submit" value="Search" class="basic_button"/> <!-- onclick="unset($_SESSION['sessionArray'])"-->
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
            // End search form
    
            // The session array exists
            if($sessionFlag)
            {
                ?>
        <!-- Use session array values to populate table -->
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
                
            // Use personID from journal table to access nickname in persons table
            $query = mysql_query("Select nickname from persons WHERE personID = '$person' limit 1");
            $nickname = mysql_result($query, 0);  
                
            $query = mysql_query("Select * from events WHERE personID = '$person'");
            while($row = mysql_fetch_array($query))
            {
                $date = $row['eventDate'];
			    $time = $row['eventTime'];
			    $subject = $row['eventSubject'];
		
			    $year = substr($date, 0, 4);
			    $month = substr($date, 5, 2);
			    $day = substr($date, 8, 2);

                $reformatted_date = $month.'-'.$day.'-'.$year;    
                
                // Output table entries
                Print "<tr>";
                    Print '<td align="center">'.$reformatted_date."</td>";
                    Print '<td align="center">'.$time."</td>"; 
                    Print '<td align="center">'.$nickname."</td>";
                    Print '<td align="center">'.$subject."</td>";
                    Print '<td align="center"><a href="viewjournal.php?id='.$row['eventID'].'"><img src="images/viewButton.png" height="13" width="13"/></a></td>';
                    Print '<td align="center"><a href="editjournal.php?id='.$row['eventID'].'"><img src="images/editButton.png" height="11" width="11"/></a></td>';
                    Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['eventID'].')"><img src="images/deleteButton.png" height="11" width="11"/></a></td>';
                Print "</tr>";                   
            }
            ?>  

            
        </table></br>                  
                
                <?php
            }
            
            // The session array has not yet been created
            else{}
    
            // Resume normal functions
            if(isset($_POST['submit']))
            {
                $pid = $_POST['person'];            
                $subject = $_POST['subject'];
                $startMonth = $_POST['startMonth'];
                $startDay = $_POST['startDay'];
                $startYear = $_POST['startYear'];
                $endMonth = $_POST['endMonth'];
                $endDay = $_POST['endDay'];
                $endYear = $_POST['endYear'];

                // Reformatted date
                $startDate = $startYear.'-'.$startMonth.'-'.$startDay;
                $endDate = $endYear.'-'.$endMonth.'-'.$endDay;
                
                // Preserve search variables
                $sessionArray = array($pid, $subject, $startDate, $endDate);
                $_SESSION['sessionArray'] = $sessionArray;
            
                // Sort output by date
                $query = mysql_query("Select * from events WHERE personID = '$pid' AND eventSubject = '$subject' ORDER BY eventDate ASC, eventTime ASC");
                if(mysql_num_rows($query) == 0){
                    Print 'There are no matches for this search.';} //////////////////////////////////////////////////NO MATCHES
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

                while($row = mysql_fetch_array($query))
                {
                
				    $date = $row['eventDate'];
                    $time = $row['eventTime'];
				
				    $year = substr($date, 0, 4);
				    $month = substr($date, 5, 2);
				    $day = substr($date, 8, 2);
				
                    // Reformat for output
				    $reformatted_date = $month.'-'.$day.'-'.$year;
                    
                    // Reformat for checkRange() function
				    $tableDate = $year.'-'.$month.'-'.$day;
                
                    // Use personID from event table to access nickname in persons table
                    $query2 = mysql_query("Select nickname from persons WHERE personID = '$pid' limit 1");
                    $nickname = mysql_result($query2, 0);       

				    if(checkRange($startDate, $endDate, $tableDate))
                    {

				// Output table entries
				Print "<tr>";
					Print '<td align="center">'.$reformatted_date."</td>";
					Print '<td align="center">'.$time."</td>"; 
                    Print '<td align="center">'.$nickname."</td>";                 
					Print '<td align="center">'.$subject."</td>";
					Print '<td align="center"><a href="viewjournal.php?id='.$row['eventID'].'"><img src="images/viewButton.png" height="13" width="13"/></a></td>';
					Print '<td align="center"><a href="editjournal.php?id='.$row['eventID'].'"><img src="images/editButton.png" height="11" width="11"/></a></td>';
					Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['eventID'].')"><img src="images/deleteButton.png" height="11" width="11"/></a></td>';
				Print "</tr>";
				    }
                }    
            }
		}
    
    // Checks that dates from events table is within range of dates specified by the user.
	function checkRange($startDate, $endDate, $tableDate)
    {
		
        // Convert to timestamp
		$start_ts = strtotime($startDate);
		$end_ts = strtotime($endDate);
		$table_ts = strtotime($tableDate);
		
		return (($table_ts >= $start_ts) && ($table_ts <= $end_ts));
	}             
 
        ?>    
        </table></br>     

		<table>
		<th colspan="2"></th>
            <tr><td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Done" class="basic_button"/></a></td>
                <td><a href="addjournal.php"><input type="button" value="Add Entry" class="basic_button"/></a></td></tr>
        </table>
    </div></center></body>
</html>