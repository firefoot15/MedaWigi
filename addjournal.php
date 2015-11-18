<!-- 	ADD JOURNAL PAGE
        Creates new event.
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
		?>

<html>
	<head>
		<title>New Entry</title>
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
		<h2>NEW ENTRY</h2>
        <div class="wrapper"> 
        <table class="page_table"><tr><td></td><td><center>
        <h1>Add Event</h1>    
		<form action="addjournal.php" method="POST">            
		<table class="table2">
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
					<?php for($i=1, $j=date("Y")+5; $i<=40; $i++, $j--){
                        if($j == date("Y"))
                            echo "<option value='$j' selected>$j</option>";
                        else
							echo "<option value='$j'>$j</option>";}
					?>
				</select></td></tr>
			<tr><td>Time: </td>
				<td><select name="hour">
					<?php for($i=13; $i>=1; $i--){
						if($i == 13)
							echo "<option value='' selected></option>";
						elseif($i<10)
							echo "<option value='0$i'>0$i</option>";
						else
							echo "<option value='$i'>$i</option>";}
					?>
				</select>
				<select name="minute">
					<?php for($i=60; $i>=0; $i-=5){
						if($i == 60)
							echo "<option value='' selected></option>";
						elseif($i<10)
							echo "<option value='0$i'>0$i</option>";
						else
							echo "<option value='$i'>$i</option>";}
					?>
				</select>
				<select name="period">
					<option value=""></option>
					<option value="AM">AM</option>
					<option value="PM">PM</option>
				</select></td></tr>	
			<tr><td>Person: </td>
				<td><select name="person">
					<?php for($i=0; $i < count($idArray); $i++){
						echo "<option value='$idArray[$i]'>$nameArray[$i]</option>";}
						
					?>
				</select></td></tr>            
			<tr><td>Subject: </td>
				<td><input type="text" name="subject" maxlength="30"/></td></tr>
			<tr><td>Content: </td>
				<td><textarea rows="10" cols="50" type="text" name="content" required="required" maxlength="1000"></textarea></td></tr>
        </table></br>
            
        <table>
        <th colspan="4"></th>    
            <tr><td></td><td></td>
                <td><a href="journal.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"/></td></tr> 
		</table>
		</form>
        </center></td></tr></table>
    </div></body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
	$month = mysql_real_escape_string($_POST['month']);
	$day = mysql_real_escape_string($_POST['day']);
	$year = mysql_real_escape_string($_POST['year']);
	$hour = mysql_real_escape_string($_POST['hour']);
	$minute = mysql_real_escape_string($_POST['minute']);
	$period = mysql_real_escape_string($_POST['period']);
    $person = mysql_real_escape_string($_POST['person']);
	$subject = mysql_real_escape_string($_POST['subject']);
	$content = mysql_real_escape_string($_POST['content']);

	$date = $year.'-'.$month.'-'.$day;
    
	if(empty($hour) || empty($minute) || empty($period))
		$time = "";
	else
		$time = $hour.':'.$minute.' '.$period;
	
	mysql_query("INSERT INTO events (eventDate, eventTime, personID, eventSubject, eventContent) VALUES ('$date','$time','$person','$subject','$content')"); 

	Print '<script>alert("Successfully added!");</script>';
	Print '<script>window.location.assign("journal.php");</script>'; 
}
?>
	
