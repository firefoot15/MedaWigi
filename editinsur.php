<!-- 	EDIT INSURANCE PAGE
        Updates insurance information associated with personID.
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

        $query = mysql_query("Select * from insurance WHERE personID = '$id'");
        $row = mysql_fetch_array($query);

        $provider = $row['insurProvider'];
		$plan = $row['insurPlan'];
		$group = $row['insurGroup'];
        $account = $row['insurAccount'];
        $rx = $row['insurRxBin'];
        $date = $row['insurDateIssued'];

		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8, 2);

        $reformatted_date = $month.'-'.$day.'-'.$year;
        ?>

<html>
	<head>
		<title>Edit Insurance</title>
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

	<body><center></br></br>
		<h2>EDIT INSURANCE</h2>
        <div class="wrapper">    
		<form action="editinsur.php" method="POST">			
		<table class="table1" cellpadding="2" cellspacing="5">
		<th2 colspan="2">Edit Insurance</th2>					
			<tr><td>Provider: </td>
				<td><input type="text" name="provider" value="<?php echo $provider; ?>" required="required" maxlength="18"/></td></tr>
			<tr><td>Plan: </td>
				<td><input type="text" name="plan" value="<?php echo $plan; ?>" required="required" maxlength="18"/></td></tr>
			<tr><td>Group #: </td>
				<td><input type="text" name="group" value="<?php echo $group; ?>" required="required" maxlength="18"/></td></tr>
            <tr><td>Account #: </td>
				<td><input type="text" name="account" value="<?php echo $account; ?>" required="required" maxlength="18"/></td></tr>
            <tr><td>Rx Bin: </td>
				<td><input type="text" name="rx" value="<?php echo $rx; ?>" required="required" maxlength="18"/></td></tr>              
            <tr><td>Issued: </td>
				<td><select name="month">
					<option value="01"<?php if($month == '01') echo 'selected="selected"'; ?>>January</option>
					<option value="02"<?php if($month == '02') echo 'selected="selected"'; ?>>February</option>
					<option value="03"<?php if($month == '03') echo 'selected="selected"'; ?>>March</option>
					<option value="04"<?php if($month == '04') echo 'selected="selected"'; ?>>April</option>
					<option value="05"<?php if($month == '05') echo 'selected="selected"'; ?>>May</option>
					<option value="06"<?php if($month == '06') echo 'selected="selected"'; ?>>June</option>
					<option value="07"<?php if($month == '07') echo 'selected="selected"'; ?>>July</option>
					<option value="08"<?php if($month == '08') echo 'selected="selected"'; ?>>August</option>
					<option value="09"<?php if($month == '09') echo 'selected="selected"'; ?>>September</option>
					<option value="10"<?php if($month == '10') echo 'selected="selected"'; ?>>October</option>
					<option value="11"<?php if($month == '11') echo 'selected="selected"'; ?>>November</option>
					<option value="12"<?php if($month == '12') echo 'selected="selected"'; ?>>December</option>
				</select>
				<select name="day">
					<?php for($i=31; $i>0; $i--){ 
						if($i<10){ 
							if($day == $i){
								echo "<option value='0$i' selected>$i</option>";}
							else{
								echo "<option value='0$i'>$i</option>";}}
						else{
							if($day == $i){
								echo "<option value='$i' selected>$i</option>";}
							else{
								echo "<option value='$i'>$i</option>";}}}
					?>
				</select>
				<select name="year">
					<?php for($i=1, $j=date("Y"); $i<=10; $i++, $j--){
						if($year == $j){
				            echo "<option value='$j' selected>$j</option>";}
						else{
				            echo "<option value='$j'>$j</option>";}}
					?>
				</select></td></tr>                
		</table></br>
            
		<table>
		<th colspan="3"></th>
			<tr><td></td>
				<td><a href="insurance.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"></td></tr> 	
		</table>
		</form>
    </div></center></body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$provider = mysql_real_escape_string($_POST['provider']);
	$plan = mysql_real_escape_string($_POST['plan']);
	$group = mysql_real_escape_string($_POST['group']);
    $account = mysql_real_escape_string($_POST['account']);
	$rx = mysql_real_escape_string($_POST['rx']);
	$month = mysql_real_escape_string($_POST['month']);
    $day = mysql_real_escape_string($_POST['day']);
    $year = mysql_real_escape_string($_POST['year']);
    
    $date = $year.'-'.$month.'-'.$day;   

	mysql_query("UPDATE insurance SET insurProvider='$provider', insurPlan='$plan', insurGroup='$group', insurAccount='$account', insurRxBin='$rx', insurDateIssued='$date' WHERE personID='$id'");

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("insurance.php");</script>'; 
}
?>