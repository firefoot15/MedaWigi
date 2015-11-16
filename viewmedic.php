<!-- 	VIEW MEDICATION PAGE
        Receives medicID and displays single row from table.
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
		?>

<html>
	<head>
		<title>View Entry</title>
		<link rel="stylesheet" type="text/css" href="style.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	</head>	
	<body><center></br></br>
        <h2>VIEW ENTRY</h2>
        <div class="wrapper">    
        <table class="table5">
        <th2 colspan="2">View Medication</th2>
            <tr><td>Name: </td>
				<td><?php echo htmlspecialchars($name); ?></td></tr>
			<tr><td>Status: </td>
				<td><?php echo htmlspecialchars($status); ?></td></tr>
			<tr><td>Rx #: </td>
				<td><?php echo htmlspecialchars($rx); ?></td></tr>            
        </table></br>
    
		<table class="table2">
			<?php
					// Output table entries
					Print '<tr><td>'.$row['medicDirections']."</td></tr>";
			?>
		</table></br>

        <a href="medications.php"><input type="button" value="Done" class="basic_button"/></a>
    </div></center></body>
</html>