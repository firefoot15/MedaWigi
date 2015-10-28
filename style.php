<?php header("Content-type: text/css");

	$id = isset($_GET['id']) ? $_GET['id'] : '';
	if(!empty($_GET['id'])){
		$_SESSION['id'] = $id;}
	
	mysql_connect("localhost", "root","") or die(mysql_error());
	mysql_select_db("medawigi") or die("Cannot connect to database.");
	$query = mysql_query("Select * from persons WHERE personID = '$id'");
	$row = mysql_fetch_array($query);	
	$profilepic = $row['profilepic'];
	//echo '<img src="data:image/png;base64,'.base64_encode( $row['profilepic'] ).'"/>';
	
	echo ".profile_button{
		display: block;
		background: #ee2c2c;
		width: 600px;
		height: 50px;
		text-align: center;
		padding: 30px 0 0 0;
		font: 1.2em/12px Verdana, Arial, Helvetica, sans-serif;
		color: #fff;
		text-decoration: none;
		-webkit-border-radius: 30px;
		-khtml-border-radius: 30px;
		-moz-border-radius: 30px;
		border-radius: 30px;
		margin-left:auto;
		margin-right:auto;
 
		background-image: <?php echo $profilepic; ?>;
		background-size: 90px auto;
		background-repeat: no-repeat; 
		background-position: 0px 0px;
		border: none;
		cursor: pointer;
		padding-left: 16px;   
		vertical-align: middle;}

		.profile_button:hover {
		background: #cd2626;
		background-image: <?php echo $profilepic; ?>;
		background-size: 90px auto;
		background-repeat: no-repeat; 
		background-position: 0px 0px; 
		border: none;   
		cursor: pointer; 
		padding-left: 16px; 
		vertical-align: middle;}";
	
?>