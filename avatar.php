	
		<?php
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		$user = $_SESSION['user'];	
		
		// id sent from editperson.php
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		if(!empty($_GET['id'])){
			$_SESSION['id'] = $id;}
		
		mysql_connect("localhost", "root","") or die(mysql_error());
		mysql_select_db("medawigi") or die("Cannot connect to database.");
		$query = mysql_query("Select * from persons WHERE personID = '$id'");
		$row = mysql_fetch_array($query);		
		
		$avatarPath = $row['profilepic'];
		$temp = substr($avatarPath, 17);
		$avatarNum = (int)$temp;
		?>
<html>
	<head>
		<title>Set Avatar</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body><center>
		<a>Current Avatar:</a></br></br>
		<input type="image" src="<?php echo htmlspecialchars($avatarPath); ?>"/>
		<table border="0" cellpadding="5" cellspacing="5" bgcolor="#202020">
		<th colspan="4">Select a new avatar...</th>
			<tr><td><img src="images/profilepic1.png"/></td>
			<td><img src="images/profilepic2.png"/></td>
			<td><img src="images/profilepic3.png"/></td>
			<td><img src="images/profilepic4.png"/></td></tr>
			<tr><td>1.</td><td>2.</td><td>3.</td><td>4.</td></tr>
			
			<tr><td><img src="images/profilepic5.png"/></td>
			<td><img src="images/profilepic6.png"/></td>
			<td><img src="images/profilepic7.png"/></td>
			<td><img src="images/profilepic8.png"/></td></tr>
			<tr><td>5.</td><td>6.</td><td>7.</td><td>8.</td></tr>
			
			<tr><td><img src="images/profilepic9.png"/></td>
			<td><img src="images/profilepic10.png"/></td>
			<td><img src="images/profilepic11.png"/></td>
			<td><img src="images/profilepic12.png"/></td></tr>
			<tr><td>9.</td><td>10.</td><td>11.</td><td>12.</td></tr>
			
			<tr><td><img src="images/profilepic13.png"/></td>
			<td><img src="images/profilepic14.png"/></td>
			<td><img src="images/profilepic15.png"/></td>
			<td><img src="images/profilepic16.png"/></td></tr>
			<tr><td>13.</td><td>14.</td><td>15.</td><td>16.</td></tr>
		</table>
		<form action="avatar.php" method="POST">
			<select name="avatar">
				<?php for($i=16; $i>=1; $i--){
					if($avatarNum == $i){
						echo "<option value='images/profilepic$i.png' selected>$i</option>";}
					else{
						echo "<option value='images/profilepic$i.png'>$i</option>";}}
				?>
			</select></br></br>
			<tr><td colspan="2" align="center">
				<a href="myportal.php"><input type="button" value="Cancel" class="basic_button"/></a>
				<input type="submit" value="Submit" class="basic_button"></td></tr> 	
		</form>		
	</center></body>
</html>		

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
	$avatarPath = mysql_real_escape_string($_POST['avatar']);
	$id = $_SESSION['id'];

	// Write to tables
	mysql_query("UPDATE persons SET profilepic='$avatarPath' WHERE personID = '$id'");

	Print '<script>alert("Successfully changed!");</script>';
	Print '<script>window.location.assign("myportal.php");</script>'; 
}
?> 