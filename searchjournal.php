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
    <img src="http://medawigi.no-ip.org/images/logo.png";/>
  </div>
  <div class="sammich">
    <img onclick="menu()" class="sammich" src="http://medawigi.no-ip.org/images/sammich-white.png" />
    <div class="menu">
      <ul id="menu-list">
        <li id="home"><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>">Home</a></li>
        <li id="insurance_contact"><a href="insurance.php">Insurance</a></li>
        <li id="calendar"><a href="calendar.php">Calendar</a></li>
        <li id="journal"><a href="journal.php">Journal</a></li>
        <li id="medications"><a href="medications.php">Medications</a></li>
        <li id="allergies"><a href="allergies.php">Allergies</a></li>
	<li id="immunizations"><a href="immunizations.php">Immunizations</a></li>
	<li id="contacts"><a href="contacts.php">Contacts</a></li>
	<li id="conditions"><a href="conditions.php">Conditions</a></li>
        <li id="contact"><a href="contact.html">Contact us</a></li>
        <li id="editprofile"><a href="editperson.php">Edit Profile</a></li>
        <li id="switch_profile"><a href="myportal.php">Switch Profile</a></li>
        <li id="logout"><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</div>
	<body>
		<h2>VIEW EVENTS</h2>
        <div class="wrapper">   
        <table class="page_table"><tr><td></td><td><center>
        <h1>Search Results</h1>            
                   
        <?php
        
        // Accepts from journal.php
        if($_SERVER['REQUEST_METHOD'] == "POST")
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
        }
        
        // Accepts from edit/view/delete pages
        // Accesses search variables saved in session array
        else
        {
            if(isset($_SESSION['sessionArray']))
            {
                $sessionArray = $_SESSION['sessionArray'];
                $pid = $sessionArray[0];  
                $subject = $sessionArray[1];
                $startDate = $sessionArray[2];
                $endDate = $sessionArray[3];           
            }
        }
            
        // Sort output by date
        $query = mysql_query("Select * from events WHERE personID = '$pid' AND eventSubject = '$subject' ORDER BY eventDate ASC, eventTime ASC");
        if(mysql_num_rows($query) == 0){
            Print 'There are no matches for this search.';}
        else{
                // Use personID from event table to access nickname in persons table
                $query2 = mysql_query("Select nickname from persons WHERE personID = '$pid' limit 1");
                $nickname = mysql_result($query2, 0);                       
                ?>
            
        <font size="6"><?php echo htmlspecialchars($nickname); ?>: <?php echo htmlspecialchars($subject); ?></font></br></br>
        <table class="table3">
			<tr>
				<th>Date</th>
				<th>Time</th>
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

				    if(checkRange($startDate, $endDate, $tableDate))
                    {

				// Output table entries
				Print "<tr>";
					Print '<td align="center">'.$reformatted_date."</td>";
					Print '<td align="center">'.$time."</td>"; 
					Print '<td align="center"><a href="viewjournal.php?id='.$row['eventID'].'"><img src="images/viewButton.png" height="17" width="17"/></a></td>';
					Print '<td align="center"><a href="editjournal.php?id='.$row['eventID'].'"><img src="images/editButton.png" height="14" width="14"/></a></td>';
					Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['eventID'].')"><img src="images/deleteButton.png" height="14" width="14"/></a></td>';
				Print "</tr>";
				    }
                    else
                    {
                        Print 'There are no matches for this search.';
                    }
                }    
			?>
        </table></br>             
            <?php
            }
			?>
            <pre>
            
            
            </pre>
        <table class="table4">
        <th colspan="2"></th>
            <tr><td><a href="journal.php"><input type="button" value="Reset Search Parameters" class="basic_button"/></a></td>                
                <td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Done" class="basic_button"/></a></td></tr>
		</table>          
            <?php            
            
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

        </center></td></tr></table>
    </div></body>
</html>
