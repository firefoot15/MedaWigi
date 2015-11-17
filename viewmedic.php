<!-- 	VIEW MEDICATION PAGE
        Receives medicID and displays single row from table.
 -->

		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}
		if(!empty($_GET['id'])){
			$_SESSION['mid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];
		$mid = $_SESSION['mid'];
		
		$query = mysql_query("Select * from medications Where medicID='$mid'"); 
		$row = mysql_fetch_array($query);
        $name = $row['medicName'];     
        $status = $row['medicStatus'];
        $rx = $row['medicRxNo'];
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
    <img />
    
  </div>
  <div class="sammich">
    <img onclick="menu()" class="sammich" src="https://cdn2.iconfinder.com/data/icons/menu-elements/154/round-border-menu-bar-128.png" />



    <div class="menu">
      <ul id="menu-list">
        <br>
        <li id="home"><a href="personhome.php">Home</a></li>
        <br>
        <li id="insurance_contact"><a href="insurance.php">Insurance</a></li>
        <br>
        <li id="calendar"><a href="calendar.php">Calendar</a></li>
        <br>
        <li id="journal"><a href="journal.php">Journal</a></li>
        <br>
        <li id="medications"><a href="medication.php">Medications</a></li>
        <br>
        <li id="allergies"><a href="allergies.php">Allergies</a></li>
        <br>
	<li id="immunizations"><a href="immunizations.php">Immunizations</a></li>
	<br>
	<li id="contacts"><a href="contacts.php">Contacts</a></li>
	<br>
	<li id="conditions"><a href="conditions.php">Conditions</a></li>
	<br>
        <li id="contact"><a href="contact.html">Contact us</a></li>
        <br>
        <li id="editprofile"><a href="editprofile.php">Edit Profile</a></li>
        <br>
        <li id="switch_profile"><a href="#">Switch Profile</a></li>
        <br>
        <li id="logout"><a href="logout.php">Logout</a></li>
        <br>
      </ul>
    </div>
  </div>

</div>
	<body>
        <h2>VIEW ENTRY</h2>
        <div class="wrapper">    
        <table class="page_table"><tr><td></td><td><center>    
        <h1>View Medication</h1>    
        <table class="table2">
            <tr><td>Name: </td>
				<td><?php echo htmlspecialchars($name); ?></td></tr>
			<tr><td>Status: </td>
				<td><?php echo htmlspecialchars($status); ?></td></tr>
			<tr><td>Rx #: </td>
				<td><?php echo htmlspecialchars($rx); ?></td></tr>            
        </table></br>
    
		<table class="table2">
			<?php
					// Output table entries
					Print '<tr><td>'.$row['medicDirections']."</td></tr>";
			?>
		</table></br>

        <a href="medications.php"><input type="button" value="Done" class="basic_button"/></a>
        </center></td></tr></table>    
    </div></body>
</html>
