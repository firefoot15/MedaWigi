		
		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		if(!empty($_GET['id'])){
			$_SESSION['jid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];			
		$jid = $_SESSION['jid'];
		
		$query = mysql_query("Select * from journal Where journalID='$jid'"); 
		$row = mysql_fetch_array($query);

		$date = $row['journalDate'];
		$time = $row['journalTime'];
		$subject = $row['journalSubject'];
		
		$year = substr($date, 0, 2);
		$month = substr($date, 3, 2);
		$day = substr($date, 6, 2);		
		
		$reformatted_date = $month.'-'.$day.'-'.$year;
		?>
<html>
	<head>
		<title>View Entry</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>	
	<style>
		table, th, td{
			width: 500px;
			font-size: 12px;
		}
	</style>
	<div id="banner"></div>	
	<body><center></br></br>
		<h2>View Entry</h2>
        <div class="wrapper">    
		<table border="0" cellpadding="2" cellspacing="5" bgcolor="#1490CC">
		<th colspan="2">Current Entry</th>		
			<tr><td>Date: </td>
				<td><?php echo htmlspecialchars($reformatted_date); ?></td></tr>	
			<tr><td>Time: </td>
				<td><?php echo htmlspecialchars($time); ?></td></tr>					
			<tr><td>Subject: </td>
				<td><?php echo htmlspecialchars($subject); ?></td></tr>			
		</table>
		<table border="1px" font color="#202020">		
			<?php
					// Output table entries
					Print '<tr><td align="center">'.$row['journalContent']."</tr></td>";
			?>
		
		</table></br>
		<table>
			<tr><td colspan="2" align="center">
				<a href="journal.php"><input type="button" value="Done" class="basic_button"/></a></tr></td>
		</table>	
    </div></center></body>
</html>