<!-- 	MY PORTAL
		Home page for account
		Selection of profiles to view/delete
		Caps number of profiles at 10
		Edit account, add person & logout option
 -->		

<html>
	<head>
		<title>My Portal</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body><center></br></br>
    <h2>My Portal</h2>	    
    <div class="wrapper">
	<body><center>    
		<form action="myportal.php" method="POST"><br/>
		<?php
        
        include 'connect.php'; 
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		$user = $_SESSION['user'];

        // Use username to access accountID in accounts table
		$query = mysql_query("Select accountID from accounts WHERE username = '$user' limit 1");
		$accountID = mysql_result($query, 0);    
            
		// Use accountID to access personIDs in mappings table      
        $query = mysql_query("Select * from mappings WHERE accountID = '$accountID'");
		$row = mysql_fetch_array($query);
            
        // Move personIDs to array    
        $idArray = array();    
        for($i = 0; $i < 10; $i++)
        {
            $colName = $i.'_personID';
            $pid = abs($row[$colName]);
            if($pid != 0)
                array_push($idArray, $pid);  
        }     

        // Use personIDs in array to populate buttons         
        for($j = 0; $j < count($idArray); $j++)    
        {
            $query = mysql_query("Select * from persons WHERE personID = '$idArray[$j]'");
            $row = mysql_fetch_array($query);
            $nickname = $row['nickname'];
			$avatarPath = $row['profilepic'];              
            
            ?>
                <!-- display profile button-->				
                <a href="personhome.php?id=<?php echo htmlspecialchars($row['personID']); ?>" class="profile_button"><img src="<?php echo htmlspecialchars($avatarPath); ?>"/><?php echo "\t\t".htmlspecialchars($nickname); ?></a><br/>
            <?php

            // The personID in 0_personID is attached to the account, it CANNOT be deleted 
            if($j != 0)
            {
                ?>
				    <!-- display delete person link-->
				    <a href="deleteperson.php?id=<?php echo htmlspecialchars($row['personID']); ?>" onClick="window.location.reload()"><img src="images/deleteButton.png" height="11" width="11"/> Delete <?php echo htmlspecialchars($nickname); ?></a><br/><br/>
                <?php                     
            }               
        }
             
        // Limit of 10 profiles attached to any account
		if(count($idArray) < 10)
		{
            ?>
                <!-- display add person button-->
				<a href="addperson.php" class="myportal_button" value="">Add Person</a><br/>
			<?php
		}
		?>    

			<!-- display edit account button-->
			<a href="editaccount.php" class="myportal_button">Edit Account</a><br/>        
			<!-- display logout button-->
			<a href="logout.php" class="myportal_button">Logout</a>
		</form>
    </center></body></div>
</html>            