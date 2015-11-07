	
		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}
				
		if(!empty($_GET['id'])){
			$_SESSION['aid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];			
		$aid = $_SESSION['aid'];
		
		$query = mysql_query("Select * from allergies Where allergyID='$aid'"); 
		$row = mysql_fetch_array($query);
		
		$name = $row['allergyName'];
		$type = $row['allergyType'];
		$severity = $row['allergySeverity'];
		?>
<html>
	<head>
		<title>Edit Entry</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>	
	<div id="banner"></div>		
	<body><center></br></br>
		<h2>Edit Entry</h2>	
        <div class="wrapper">    
		<form action="editallergy.php" method="POST">			
		<table class="table1" cellpadding="2" cellspacing="5">
		<th colspan="2">Edit Entry</th>					
			<tr><td>Name: </td>
				<td><input type="text" name="name" value="<?php echo $name; ?>" required="required" maxlength="30"/></td></tr>
			<tr><td>Type: </td>
				<td><select name="type">
					<option value="Indoors"<?php if($type == 'Indoors') echo 'selected="selected"'; ?>>Indoors</option>
					<option value="Outdoors"<?php if($type == 'Outdoors') echo 'selected="selected"'; ?>>Outdoors</option>
					<option value="Food"<?php if($type == 'Food') echo 'selected="selected"'; ?>>Food</option>
					<option value="Other"<?php if($type == 'Other') echo 'selected="selected"'; ?>>Other</option>
				</select></td></tr>
			<tr><td>Severity: </td>
				<td><select name="severity">
					<option value="Mild"<?php if($severity == 'Mild') echo 'selected="selected"'; ?>>Mild</option>
					<option value="Moderate"<?php if($severity == 'Moderate') echo 'selected="selected"'; ?>>Moderate</option>
					<option value="Severe"<?php if($severity == 'Severe') echo 'selected="selected"'; ?>>Severe</option>
				</select></td></tr>		
		</table></br>
            
		<table>
		<th colspan="3"></th>		
			<tr><td></td>			
				<td><a href="allergies.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"></td></tr> 	
		</table>
		</form>		
    </div></center></body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$name = mysql_real_escape_string($_POST['name']);
	$type = mysql_real_escape_string($_POST['type']);
	$severity = mysql_real_escape_string($_POST['severity']);

	$aid = $_SESSION['aid'];	

	mysql_query("UPDATE allergies SET allergyName='$name', allergyType='$type', allergySeverity='$severity' WHERE allergyID='$aid'");

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("allergies.php");</script>'; 
}
?>