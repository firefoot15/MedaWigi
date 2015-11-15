<!-- 	EDIT CONDITION PAGE
        Receives condiID and updates single row from table.
 -->

		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}
				
		if(!empty($_GET['id'])){
			$_SESSION['oid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];
		$oid = $_SESSION['oid'];
		
		$query = mysql_query("Select * from conditions Where condiID='$oid'"); 
		$row = mysql_fetch_array($query);
		
        $name = $row['condiName']; 
        $description = $row['condiDescription'];
		?>

<html>
	<head>
		<title>Edit Entry</title>
		<link rel="stylesheet" type="text/css" href="style.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'
	</head>		
	<body><center></br></br>
		<h2>EDIT ENTRY</h2>
        <div class="wrapper">    
		<form action="editcondi.php" method="POST">
		<table class="table2">
		<th colspan="2">Edit Entry</th>
			<tr><td>Name: </td>
				<td><input type="text" name="name" value="<?php echo $name; ?>" required="required" maxlength="30"/></td></tr>
			<tr><td>Description: </td>
				<td><textarea rows="20" cols="50" type="text" name="description" required="required" maxlength="350"><?php echo $description; ?></textarea></td></tr>
		</table></br>
        
        <table>
        <th colspan="4"></th>    
            <tr><td></td><td></td>
				<td><a href="conditions.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"></td></tr> 
		</table>
		</form>
    </div></center></body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$name = mysql_real_escape_string($_POST['name']);
	$description = mysql_real_escape_string($_POST['description']);
    
	mysql_query("UPDATE conditions SET condiName='$name', condiDescription='$description' WHERE condiID='$oid'");

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("conditions.php");</script>'; 
}
?>