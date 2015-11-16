<!-- 	EDIT CONTACT PAGE
        Receives contactID and updates single row from table.
 -->

		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}
				
		if(!empty($_GET['id'])){
			$_SESSION['cid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];
		$cid = $_SESSION['cid'];
		
		$query = mysql_query("Select * from contacts Where contactID='$cid'"); 
		$row = mysql_fetch_array($query);
		
		$name = $row['contactName'];
		$relationship = $row['contactRelationship'];
		$phone = $row['contactPhone'];

		$areaCode = substr($phone, 0, 3);
		$exchangeCode = substr($phone, 4, 3);
		$subscriberNumber = substr($phone, 8, 4);
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
		<form action="editcontact.php" method="POST">
		<table class="table1" cellpadding="2" cellspacing="5">
		<th2 colspan="2">Edit Contact</th2>
			<tr><td>Name: </td>
				<td><input type="text" name="name" value="<?php echo $name; ?>" required="required" maxlength="30"/></td></tr>
			<tr><td>Relationship: </td>
				<td><input type="text" name="relationship" value="<?php echo $relationship; ?>" required="required" maxlength="30"/></td></tr>
			<tr><td>Phone: </td>
				<td><input type="text" name="areaCode" value="<?php echo $areaCode; ?>" required="required" maxlength="3" size="3"/>
                    <input type="text" name="exchangeCode" value="<?php echo $exchangeCode; ?>" required="required" maxlength="3" size="3"/>
                    <input type="text" name="subscriberNumber" value="<?php echo $subscriberNumber; ?>" required="required" maxlength="4" size="4"/></td></tr>
		</table></br>
            
		<table>
		<th colspan="3"></th>
			<tr><td></td>
				<td><a href="contacts.php"><input type="button" value="Cancel" class="basic_button"/></a></td>
				<td><input type="submit" value="Submit" class="basic_button"></td></tr> 
		</table>
		</form>		
    </div></center></body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$name = mysql_real_escape_string($_POST['name']);
	$relationship = mysql_real_escape_string($_POST['relationship']);
	$areaCode = mysql_real_escape_string($_POST['areaCode']);
	$exchangeCode = mysql_real_escape_string($_POST['exchangeCode']);
	$subscriberNumber = mysql_real_escape_string($_POST['subscriberNumber']); 
    
    $bool = true;
    
	// Validate phone number
	if(strlen($areaCode) < 3 || !ctype_digit($areaCode) || strlen($exchangeCode) < 3 || !ctype_digit($exchangeCode) || strlen($subscriberNumber) < 4 || !ctype_digit($subscriberNumber))
	{
		$bool = false;
		Print '<script>alert("Invalid phone number!");</script>'; 
		Print '<script>window.location.assign("editcontact.php");</script>';
	}
    
	if($bool)   
    {
        $phone = $areaCode.'-'.$exchangeCode.'-'.$subscriberNumber;
        
        mysql_query("UPDATE contacts SET contactName='$name', contactRelationship='$relationship', contactPhone='$phone' WHERE contactID='$cid'");

        Print '<script>alert("Successfully changed!");</script>';
        Print '<script>window.location.assign("contacts.php");</script>'; 
    }
}
?>