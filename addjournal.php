	
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
	</head>			
	<body><center></br></br>
		<h2>New Entry</h2>	
        <div class="wrapper">     
		<form action="addjournal.php" method="POST">            
		<table class="table2">
		<th colspan="2">New Entry</th>		
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
					<?php for($i=1, $j=date("Y"); $i<=80; $i++, $j--){
						$k=$j%100;
						if($k<10)
							echo "<option value='0$k'>$j</option>";
						else
							echo "<option value='$k'>$j</option>";}
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
				<td><textarea rows="20" cols="50" type="text" name="content" required="required" maxlength="1000"></textarea></td></tr>
        </table></br>
            
        <table>
        <th colspan="4"></th>    
            <tr><td></td><td></td>
                <td><a href="journal.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"/></td></tr> 	
		</table>
		</form>            
    </div></center></body>
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
	
	mysql_query("INSERT INTO journal (journalDate, journalTime, personID, journalSubject, journalContent, accountID) VALUES ('$date','$time','$person','$subject','$content','$accountID')"); 	

	Print '<script>alert("Successfully added!");</script>';
	Print '<script>window.location.assign("journal.php");</script>'; 
}
?>
	