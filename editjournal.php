	
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
		$content = $row['eventContent'];
			
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8, 2);
							
		$hour = substr($time, 0, 2);
		$minute = substr($time, 3, 2);
		$period = substr($time, 6, 2);

        $pid = $row['personID'];
        $query = mysql_query("Select nickname from persons WHERE personID = '$pid' limit 1");
        $person = mysql_result($query, 0);   

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
		<title>Edit Entry</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>		
	<body><center></br></br>
		<h2>Edit Entry</h2>
        <div class="wrapper">    
		<form action="editjournal.php" method="POST">
		<table class="table2">
		<th colspan="2">Edit Entry</th>
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
					<?php for($i=1, $j=date("Y")+5; $i<=40; $i++, $j--){
						if($year == $j){
				            echo "<option value='$j' selected>$j</option>";}
						else{
				            echo "<option value='$j'>$j</option>";}}
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
			<tr><td>Person: </td>
				<td><select name="person">
					<?php for($i=0; $i < count($idArray); $i++){
                        if($person == $nameArray[$i]){ 
                            echo "<option value='$idArray[$i]' selected>$nameArray[$i]</option>";}
                        else{
                            echo "<option value='$idArray[$i]'>$nameArray[$i]</option>";}}
                    
					?>
				</select></td></tr>              
            <tr><td>Subject: </td>
				<td><input type="text" name="subject" value="<?php echo $subject; ?>" maxlength="30"/></td></tr>
			<tr><td>Content: </td>
				<td><textarea rows="20" cols="50" type="text" name="content" required="required" maxlength="1000"><?php echo $content; ?></textarea></td></tr>
		</table></br>
        
        <table>
        <th colspan="4"></th>    
            <tr><td></td><td></td>
				<td><a href="journal.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"></td></tr> 
		</table>
		</form>
    </div></center></body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$month = mysql_real_escape_string($_POST['month']);
	$day = mysql_real_escape_string($_POST['day']);
	$year = mysql_real_escape_string($_POST['year']);
	$hour = mysql_real_escape_string($_POST['hour']);
	$minute = mysql_real_escape_string($_POST['minute']);
	$period = mysql_real_escape_string($_POST['period']);
    $person = mysql_real_escape_string($_POST['person']);    
	$subject = mysql_real_escape_string($_POST['subject']);
	$content = mysql_real_escape_string($_POST['content']);

	if(empty($year) || empty($month) || empty($day))
		$date = "";
	else
		$date = $year.'-'.$month.'-'.$day;    
    
    
    if(empty($hour) || empty($minute) || empty($period))
		$time = "";
	else
		$time = $hour.':'.$minute.' '.$period;

	mysql_query("UPDATE events SET eventDate='$date', eventTime='$time', personID='$person', eventSubject='$subject', eventContent='$content' WHERE eventID='$eid'");

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("journal.php");</script>'; 
}
?>