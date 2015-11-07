<?php
    include 'connect.php';
	session_start(); 
	if($_SESSION['user']){ }
	else{
		header("location:index.php");}

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
        for($i = 1; $i < 10; $i++)
        {
            // Find correct personID out of row
            $colName = $i.'_personID';
            if(abs($row[$colName]) == $id)
            {   /*
                // If negative (linked), remove only from mappings table
                if($row[$colName] < 0)
                {
                    mysql_query("UPDATE mappings SET $colName=0 WHERE accountID = '$accountID'"); //expecting error
                    mysql_query("DELETE FROM journal WHERE accountID = '$accountID'");        // go back and look at this                                       
                }
                */
                // Else remove from all tables
                //else 
                //{
                /*    
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
 
                    }*/
                    mysql_query("UPDATE mappings SET 4_personID= WHERE accountID = '$accountID'"); 
                    mysql_query("DELETE FROM persons WHERE personID='$id'");
                    mysql_query("DELETE FROM allergies WHERE personID='$id'");                     
                    mysql_query("DELETE FROM journal WHERE personID='$id'");                  
                //}    
            }
        }  		
		header("location:myportal.php");
	}
?>