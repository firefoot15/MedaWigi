		
		<?php
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		if(!empty($_GET['id'])){
			$_SESSION['jid'] = $_GET['id'];}
			
		$user = $_SESSION['user'];			
		$jid = $_SESSION['jid'];
		
		mysql_connect("localhost", "root","") or die(mysql_error()); 
		mysql_select_db("medawigi") or die("Cannot connect to database");
		$query = mysql_query("Select * from journal Where journalID='$jid'"); 
		$row = mysql_fetch_array($query);	
		
		?>
<html>
	<head>
		<title>View Entry</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>	
	<style>
		table, th, td{
			width: 550px;
			font-size: 10px;
		}
	</style>
	<div id="banner"></div>	
	<body><center></br></br>
		<h2>View Entry</h2>
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
	</center></body>
</html>