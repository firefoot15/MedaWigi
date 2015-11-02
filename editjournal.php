	
		<?php
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		if(!empty($_GET['id'])){
			$_SESSION['jid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];			
		$jid = $_SESSION['jid'];
		
		mysql_connect("localhost", "root","") or die(mysql_error()); 
		mysql_select_db("medawigi") or die("Cannot connect to database");
		$query = mysql_query("Select * from journal Where journalID='$jid'"); 
		$row = mysql_fetch_array($query);
		
		$date = $row['journalDate'];
		$time = $row['journalTime'];
		$subject = $row['journalSubject'];
		$content = $row['journalContent'];
			
		$year = substr($date, 0, 2);
		$month = substr($date, 3, 2);
		$day = substr($date, 6, 2);
							
		$hour = substr($time, 0, 2);
		$minute = substr($time, 3, 2);
		$period = substr($time, 6, 2);

		?>
<html>
	<head>
		<title>Edit Entry</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>	
	<div id="banner"></div>		
	<body><center></br></br>
		<h2>Edit Entry</h2>	
		<table border="0" cellpadding="2" cellspacing="5" bgcolor="#1490CC">
		<th colspan="2">Edit Entry</th>		
		<form action="editjournal.php" method="POST">
			<tr><td>Date: </td>
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
					<?php for($i=1, $j=date("Y"); $i<=80; $i++, $j--){
						$k=$j%100;
						if($year == $k){
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
			<tr><td>Time: </td>
				<td><select name="hour">
					<?php for($i=13; $i>0; $i--){
						if(empty($hour)){
							if($i == 13){
								echo "<option value='' selected></option>";}
							elseif($i<10){
								echo "<option value='0$i'>0$i</option>";}
							else{
								echo "<option value='$i'>$i</option>";}}
						else{	
							if($i == 13){
								echo "<option value=''></option>";}
							elseif($i<10){
								if($hour == $i){
									echo "<option value='0$i' selected>0$i</option>";}
								else{
									echo "<option value='0$i'>0$i</option>";}}
							else{
								if($hour == $i){
									echo "<option value='$i' selected>$i</option>";}
								else{
									echo "<option value='$i'>$i</option>";}}}}
					?>					
				</select>
				<select name="minute">
					<?php for($i=60; $i>=0; $i-=5){
						if(empty($minute)){
							if($i == 60){
								echo "<option value='' selected></option>";}							
							elseif($i<10){
								echo "<option value='0$i'>0$i</option>";}
							else{
								echo "<option value='$i'>$i</option>";}}						
						else{
							if($i == 60){
								echo "<option value=''></option>";}
							elseif($i<10){
								if($minute == $i){
									echo "<option value='0$i' selected>0$i</option>";}
								else{
									echo "<option value='0$i'>0$i</option>";}}
							else{
								if($minute == $i){
									echo "<option value='$i' selected>$i</option>";}
								else{
									echo "<option value='$i'>$i</option>";}}}}
					?>
				</select>
				<select name="period">
					<option value=""<?php if(empty($period)) echo 'selected="selected"'; ?>></option>
					<option value="AM"<?php if($period == 'AM') echo 'selected="selected"'; ?>>AM</option>
					<option value="PM"<?php if($period == 'PM') echo 'selected="selected"'; ?>>PM</option>
				</select></td></tr>						
			<tr><td>Subject: </td>
				<td><input type="text" name="subject" value="<?php echo $subject; ?>" maxlength="30"/></td></tr>
			<tr><td>Content: </td>
				<td><textarea rows="20" cols="50" type="text" name="content" required="required" maxlength="1000"><?php echo $content; ?></textarea></td></tr>			
			<tr><td colspan="2" align="center">
				<a href="journal.php"><input type="button" value="Cancel" class="basic_button"/></a>
				<input type="submit" value="Submit" class="basic_button"></td></tr> 	
				
				<!-- content size not registering at all-->
		</form>
		</table>
	</center></body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$month = mysql_real_escape_string($_POST['month']);
	$day = mysql_real_escape_string($_POST['day']);
	$year = mysql_real_escape_string($_POST['year']);
	$hour = mysql_real_escape_string($_POST['hour']);
	$minute = mysql_real_escape_string($_POST['minute']);
	$period = mysql_real_escape_string($_POST['period']);		
	$subject = mysql_real_escape_string($_POST['subject']);
	$content = mysql_real_escape_string($_POST['content']);

	$jid = $_SESSION['jid'];	
	$date = $year.'-'.$month.'-'.$day;
	if(empty($hour) || empty($minute) || empty($period))
		$time = "";
	else
		$time = $hour.':'.$minute.' '.$period;

	mysql_query("UPDATE journal SET journalDate='$date', journalTime='$time', journalSubject='$subject', journalContent='$content' WHERE journalID='$jid'");

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("journal.php");</script>'; 
}
?>