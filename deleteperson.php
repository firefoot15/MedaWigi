<html>
	<head>
		<title>My Portal</title>
	</head>
    <body><center>  

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

	// Get personID of profile user desires to delete
	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
        $id = $_GET['id'];
        $temp = 0;
        for($i = 1; $i < 10; $i++)
        {            
            // Remove personID user desires to delete // from current row only
            $colName = $i.'_personID';
            if(abs($row[$colName]) == $id)
            {                                 
                switch($i)
                {
                    case 1: 
                        mysql_query("UPDATE mappings SET 1_personID=0 WHERE accountID = '$accountID'"); 
                        break;
                    case 2:
                        mysql_query("UPDATE mappings SET 2_personID=0 WHERE accountID = '$accountID'"); 
                        break;
                    case 3:
                        mysql_query("UPDATE mappings SET 3_personID=0 WHERE accountID = '$accountID'"); 
                        break;
                    case 4:
                        mysql_query("UPDATE mappings SET 4_personID=0 WHERE accountID = '$accountID'"); 
                        break;
                    case 5:
                        mysql_query("UPDATE mappings SET 5_personID=0 WHERE accountID = '$accountID'"); 
                        break;
                    case 6:
                        mysql_query("UPDATE mappings SET 6_personID=0 WHERE accountID = '$accountID'"); 
                        break;     
                    case 7:
                        mysql_query("UPDATE mappings SET 7_personID=0 WHERE accountID = '$accountID'"); 
                        break;
                    case 8:
                        mysql_query("UPDATE mappings SET 8_personID=0 WHERE accountID = '$accountID'"); 
                        break;
                    case 9:
                        mysql_query("UPDATE mappings SET 9_personID=0 WHERE accountID = '$accountID'"); 
                        break;    
                }
                $temp = $row[$colName]; // signed value
            }
        }                     
        
        // Remove connections for linked account
        if($temp < 0)
        {
            // mysql_query("DELETE FROM journal WHERE accountID = '$accountID' AND personID='$id'");
        }

        // Remove all entries for user account        
        else
        {
            // mysql_query("DELETE FROM persons WHERE personID='$id'");
            // mysql_query("DELETE FROM allergies WHERE personID='$id'");                     
            // mysql_query("DELETE FROM journal WHERE personID='$id'");              
            
            // Also remove all instances from table
            $query2 = mysql_query("Select * from mappings");
            while($row2 = mysql_fetch_array($query2))
            {
                $mid = $row2['mappingID'];
                
 
                for($i = 1; $i < 10; $i++)
                {
                    $colName2 = $i.'_personID';
                    
                    
                                                                              ?>
        		<th><?php echo $row2[$colName2];?>!</th></br></br>
    </center></body></html>
        <?php                            
               
                    if($row2[$colName2] == $temp*(-1)) 
                    {
                        switch($i)
                        {
                            case 1: 
                                mysql_query("UPDATE mappings SET 1_personID=0 WHERE mappingID = '$mid'"); 
                                break;
                            case 2:
                                mysql_query("UPDATE mappings SET 2_personID=0 WHERE mappingID = '$mid'"); 
                                break;
                            case 3:
                                mysql_query("UPDATE mappings SET 3_personID=0 WHERE mappingID = '$mid'"); 
                                break;
                            case 4:
                                mysql_query("UPDATE mappings SET 4_personID=0 WHERE mappingID = '$mid'"); 
                                break;
                            case 5:
                                mysql_query("UPDATE mappings SET 5_personID=0 WHERE mappingID = '$mid'"); 
                                break;
                            case 6:
                                mysql_query("UPDATE mappings SET 6_personID=0 WHERE mappingID = '$mid'"); 
                                break;     
                            case 7:
                                mysql_query("UPDATE mappings SET 7_personID=0 WHERE mappingID = '$mid'"); 
                                break;
                            case 8:
                                mysql_query("UPDATE mappings SET 8_personID=0 WHERE mappingID = '$mid'"); 
                                break;
                            case 9:
                                mysql_query("UPDATE mappings SET 9_personID=0 WHERE mappingID = '$mid'"); 
                                break;    
                        }                
                    }

                    
                    
                    
                }
                
          
                
            }
        }
        //header("location:myportal.php");
    }
?>