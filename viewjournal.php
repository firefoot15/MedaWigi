<!-- 	VIEW JOURNAL PAGE
        Receives journalID and displays single row from table.
 -->

		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}
		if(!empty($_GET['id'])){
			$_SESSION['eid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];
		$eid = $_SESSION['eid'];
		
		$query = mysql_query("Select * from events Where eventID='$eid'"); 
		$row = mysql_fetch_array($query);
		$date = $row['eventDate'];
		$time = $row['eventTime'];
		$subject = $row['eventSubject'];
		
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8, 2);
		
		$reformatted_date = $month.'-'.$day.'-'.$year;
        $pid = $row['personID'];
        $query2 = mysql_query("Select nickname from persons WHERE personID = '$pid' limit 1");
        $person = mysql_result($query2, 0);   
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
        <table class="table2">
        <th colspan="2">Current Entry</th>
            <tr><td>Date: </td>
				<td><?php echo htmlspecialchars($reformatted_date); ?></td></tr>
			<tr><td>Time: </td>
				<td><?php echo htmlspecialchars($time); ?></td></tr>
			<tr><td>Person: </td>
				<td><?php echo htmlspecialchars($person); ?></td></tr>            
			<tr><td>Subject: </td>
				<td><?php echo htmlspecialchars($subject); ?></td></tr>
        </table></br>
    
		<table class="table3">
			<?php
					// Output table entries
					Print '<tr><td>'.$row['eventContent']."</td></tr>";
			?>
		</table></br>

        <a href="journal.php"><input type="button" value="Done" class="basic_button"/></a>
    </div></center></body>
</html>
