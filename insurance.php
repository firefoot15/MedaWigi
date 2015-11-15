<!-- 	INSURANCE PAGE
        Displays insurance information associated with personID.
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
		<title>Insurance</title>
		<link rel="stylesheet" type="text/css" href="style.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'
	</head>	
	<body><center></br></br>
		<h2>INSURANCE</h2>
        <div class="wrapper">   
            
        <?php
            
        // View insurance form    
        if(isset($provider))
        {
            ?>
		<table class="table1" cellpadding="2" cellspacing="5">
		<th colspan="2">Insurance</th>
			<tr><td>Provider: </td>
				<td><?php echo $provider; ?></td></tr>
			<tr><td>Plan: </td>
				<td><?php echo $plan; ?></td></tr>
			<tr><td>Group #: </td>
				<td><?php echo $group; ?></td></tr>
            <tr><td>Account #: </td>
				<td><?php echo $account; ?></td></tr>
            <tr><td>Rx Bin: </td>
				<td><?php echo $rx; ?></td></tr>
            <tr><td>Issued: </td>
				<td><?php echo $reformatted_date; ?></td></tr>  
        </table></br>
    
		<table>
		<th colspan="2"></th>
            <tr><td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Done" class="basic_button"/></a></td>
                <td><a href="editinsur.php"><input type="button" value="Edit Insurance" class="basic_button"/></a></td></tr>
        </table>    
    
            <?php
        }
        
        // Add insurance form
        else
        {
            ?>
		<table class="table1" cellpadding="2" cellspacing="5">
		<th colspan="2">Insurance</th>
        <form action="insurance.php" id="addEntry" name="addEntryFrom" style="display:none;" method="POST">
			<tr><td>Provider: </td>
				<td><input type="text" name="provider" required="required" maxlength="18"/></td></tr>
			<tr><td>Plan: </td>
				<td><input type="text" name="plan" required="required" maxlength="18"/></td></tr>
			<tr><td>Group #: </td>
				<td><input type="text" name="group" required="required" maxlength="18"/></td></tr>
            <tr><td>Account #: </td>
				<td><input type="text" name="account" required="required" maxlength="18"/></td></tr>
            <tr><td>Rx Bin: </td>
				<td><input type="text" name="rx" required="required" maxlength="18"/></td></tr>
            <tr><td>Issued: </td>
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
					<?php for($i=1, $j=date("Y"); $i<=10; $i++, $j--){
                            echo "<option value='$j'>$j</option>";}
					?>
				</select></td></tr>
			<tr><td></td></tr>
            <tr><td></td>
				<td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Cancel" class="basic_button"/></a>
				<input type="submit" name="submitAddEntry" onClick="window.location.reload()" value="Submit" class="basic_button"></td></tr>            
        </form>    
        </table>
            <?php            
        }
            
           ?>        
    </div></center></body>
</html>            


<?php
if (isset($_POST['submitAddEntry'])) {
	$provider = mysql_real_escape_string($_POST['provider']);
	$plan = mysql_real_escape_string($_POST['plan']);
	$group = mysql_real_escape_string($_POST['group']);
    $account = mysql_real_escape_string($_POST['account']);
	$rx = mysql_real_escape_string($_POST['rx']);
	$month = mysql_real_escape_string($_POST['month']);
    $day = mysql_real_escape_string($_POST['day']);
    $year = mysql_real_escape_string($_POST['year']);
    
    $date = $year.'-'.$month.'-'.$day;      

	mysql_query("INSERT INTO insurance (insurProvider, insurPlan, insurGroup, insurAccount, insurRxBin, insurDateIssued, personID) VALUES ('$provider','$plan','$group','$account','$rx','$date','$id')");

	Print '<script>alert("Successfully added!");</script>';
	Print '<script>window.location.assign("insurance.php");</script>'; 
}
?>