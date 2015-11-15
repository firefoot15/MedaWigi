<!-- 	ADD CONDITION PAGE
        Creates new condition entry.
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
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'
	</head>
	<body><center></br></br>
		<h2>NEW ENTRY</h2>
        <div class="wrapper">     
		<form action="addcondi.php" method="POST">            
		<table class="table2">
		<th colspan="2">New Entry</th>         
			<tr><td>Name: </td>
				<td><input type="text" name="name" required="required" maxlength="30"/></td></tr>                     
			<tr><td>Description: </td>
				<td><textarea rows="10" cols="50" type="text" name="description" required="required" maxlength="350"></textarea></td></tr>
        </table></br>
            
        <table>
        <th colspan="4"></th>    
            <tr><td></td><td></td>
                <td><a href="conditions.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"/></td></tr> 
		</table>
		</form>            
    </div></center></body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
	$name = mysql_real_escape_string($_POST['name']);
	$description = mysql_real_escape_string($_POST['description']);
	
	mysql_query("INSERT INTO conditions (condiName, condiDescription, personID) VALUES ('$name','$description','$id')"); 

	Print '<script>alert("Successfully added!");</script>';
	Print '<script>window.location.assign("conditions.php");</script>'; 
}
?>
	