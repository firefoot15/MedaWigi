<!-- 	VIEW CONDITION PAGE
        Receives condiID and displays single row from table.
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
 
        <th2>View Condition:</th2></br>
        <?php echo htmlspecialchars($name); ?></br></br>
        
    
		<table class="table2">
			<?php
					// Output table entries
					Print '<tr><td>'.$row['condiDescription']."</td></tr>";
			?>
		</table></br>

        <a href="conditions.php"><input type="button" value="Done" class="basic_button"/></a>
    </div></center></body>
</html>