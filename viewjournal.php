<!-- 	VIEW JOURNAL PAGE
        Receives journalID and displays single row from table.
 -->

		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}
		if(!empty($_GET['id'])){
			$_SESSION['eid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];
		$eid = $_SESSION['eid'];
		
		$query = mysql_query("Select * from events Where eventID='$eid'"); 
		$row = mysql_fetch_array($query);
		$date = $row['eventDate'];
		$time = $row['eventTime'];
		$subject = $row['eventSubject'];
		
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8, 2);
		
		$reformatted_date = $month.'-'.$day.'-'.$year;
        $pid = $row['personID'];
        $query2 = mysql_query("Select nickname from persons WHERE personID = '$pid' limit 1");
        $person = mysql_result($query2, 0);   
		?>

<html>
	<head>
		<title>View Entry</title>
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
        <li id="home"><a href="personhome.php">Home</a></li>
        <li id="insurance_contact"><a href="insurance.php">Insurance</a></li>
        <li id="calendar"><a href="calendar.php">Calendar</a></li>
        <li id="journal"><a href="journal.php">Journal</a></li>
        <li id="medications"><a href="medications.php">Medications</a></li>
        <li id="allergies"><a href="allergies.php">Allergies</a></li>
	<li id="immunizations"><a href="immunizations.php">Immunizations</a></li>
	<li id="contacts"><a href="contacts.php">Contacts</a></li>
	<li id="conditions"><a href="conditions.php">Conditions</a></li>
        <li id="contact"><a href="contact.html">Contact us</a></li>
        <li id="editprofile"><a href="editprofile.php">Edit Profile</a></li>
        <li id="switch_profile"><a href="personhome.php">Switch Profile</a></li>
        <li id="logout"><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</div>
	<body>
        <h2>VIEW ENTRY</h2>
        <div class="wrapper">  
        <table class="page_table"><tr><td></td><td><center>    
        <h1>View Event</h1> 
        <table class="table2">
            <tr><td>Date: </td>
				<td><?php echo htmlspecialchars($reformatted_date); ?></td></tr>
			<tr><td>Time: </td>
				<td><?php echo htmlspecialchars($time); ?></td></tr>
			<tr><td>Person: </td>
				<td><?php echo htmlspecialchars($person); ?></td></tr>            
			<tr><td>Subject: </td>
				<td><?php echo htmlspecialchars($subject); ?></td></tr>
        </table></br>
    
		<table class="table2">
			<?php
					// Output table entries
					Print '<tr><td>'.$row['eventContent']."</td></tr>";
			?>
		</table></br>

        <a href="searchjournal.php"><input type="button" value="Done" class="basic_button"/></a>
        </center></td></tr></table>    
    </div></body>
</html>
