<!-- 	ADD MEDICATION PAGE
        Creates new medication entry.
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
		?>

<html>
	<head>
		<title>New Entry</title>
		<link rel="stylesheet" type="text/css" href="style.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	</head>
	<body><center></br></br>
		<h2>NEW ENTRY</h2>
        <div class="wrapper">     
		<form action="addmedic.php" method="POST">            
		<table class="table2">
		<th colspan="2">New Entry</th>         
			<tr><td>Name: </td>
				<td><input type="text" name="name" required="required" maxlength="50" size="50"/></td></tr>          
			<tr><td>Status: </td>
                <td><input type="checkbox" name="status" value="Current"/></td></tr>
			<tr><td>Rx #: </td>
				<td><input type="text" name="rx" maxlength="15"/></td></tr>              
			<tr><td>Directions: </td>
				<td><textarea rows="10" cols="50" type="text" name="directions" required="required" maxlength="100"></textarea></td></tr>
        </table></br>
            
        <table>
        <th colspan="4"></th>    
            <tr><td></td><td></td>
                <td><a href="medications.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"/></td></tr> 
		</table>
		</form>            
    </div></center></body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
	$name = mysql_real_escape_string($_POST['name']);
	$rx = mysql_real_escape_string($_POST['rx']);
	$directions = mysql_real_escape_string($_POST['directions']);
    
    if(isset($_POST['status']))
        $status = $_POST['status'];
    else
        $status = 'Expired';
	
	mysql_query("INSERT INTO medications (medicName, medicDirections, medicRxNo, medicStatus, personID) VALUES ('$name','$directions','$rx','$status','$id')"); 

	Print '<script>alert("Successfully added!");</script>';
	Print '<script>window.location.assign("medications.php");</script>'; 
}
?>
	