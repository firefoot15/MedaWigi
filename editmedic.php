<!-- 	EDIT MEDICATION PAGE
        Receives medicID and updates single row from table.
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
        $directions = $row['medicDirections'];
		?>

<html>
	<head>
		<title>Edit Entry</title>
		<link rel="stylesheet" type="text/css" href="style.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	</head>		
	<body><center></br></br>
		<h2>EDIT ENTRY</h2>
        <div class="wrapper">    
		<form action="editmedic.php" method="POST">
		<table class="table2">
		<th2 colspan="2">Edit Medication</th2>
			<tr><td>Name: </td>
				<td><input type="text" name="name" value="<?php echo $name; ?>" required="required" maxlength="50"/></td></tr>
			<tr><td>Status: </td>
                <td><input type="checkbox" name="status" value="Current"<?php if($status == 'Current') echo 'checked="checked"'; ?>></td></tr>
            <tr><td>Rx #: </td>
				<td><input type="text" name="rx" value="<?php echo $rx; ?>" maxlength="15"/></td></tr>
			<tr><td>Directions: </td>
				<td><textarea rows="10" cols="50" type="text" name="directions" required="required" maxlength="100"><?php echo $directions; ?></textarea></td></tr>
		</table></br>
        
        <table>
        <th colspan="4"></th>    
            <tr><td></td><td></td>
				<td><a href="medications.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"></td></tr> 
		</table>
		</form>
    </div></center></body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$name = mysql_real_escape_string($_POST['name']);
	$rx = mysql_real_escape_string($_POST['rx']);
	$directions = mysql_real_escape_string($_POST['directions']);
    
    if(isset($_POST['status']))
        $status = $_POST['status'];
    else
        $status = 'Expired';

	mysql_query("UPDATE medications SET medicName='$name', medicDirections='$directions', medicRxNo='$rx', medicStatus='$status' WHERE medicID='$mid'");

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("medications.php");</script>'; 
}
?>