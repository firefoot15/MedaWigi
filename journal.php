<!--    JOURNAL PAGE
        Users set search criteria for events. 
        Allows user to access events for all persons attached to account.
        Hidden add event form.
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
            $sessionArray = $_SESSION['sessionArray'];
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
    <img onclick="menu()" class="sammich" src="https://cdn2.iconfinder.com/data/icons/menu-elements/154/round-border-menu-bar-128.png" />
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
</div>              <!--   Search form   -->
	<body>
		<h2>SEARCH ENTRIES</h2>
        <div class="wrapper">
        <table class="page_table"><tr><td></td><td><center>
        <h1>Basic Search</h1>                
		<form action="searchjournal.php" method="POST">
		<table class="table1">
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

		<table>
		<th colspan="4"></th>
            <tr><td></td>            
                <td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Done" class="basic_button"/></a></td>
                <td><a href="addjournal.php"><input type="button" value="Add Entry" class="basic_button"/></a></td>
                <td><a href="searchjournal.php"><input type="submit" value="Search" class="basic_button"/></a></td></tr>
        </table>            
		</form>    
        </center></td></tr></table>    
    </div></body>
</html>
