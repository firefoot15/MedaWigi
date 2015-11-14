<!-- 	DELETE PERSON PAGE
		Receives personID from myportal.php 
        Delete dependent on whether person is linked or original to account.
        IF linked, remove personID from mappings table only on account's row.
        Otherwise, remove every instance of personID from all tables.
 -->

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
            // Remove personID user desires to delete from current account
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
                
                // Preserve signed value
                $temp = $row[$colName];
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
            mysql_query("DELETE FROM persons WHERE personID='$id'");
            mysql_query("DELETE FROM immunizations WHERE personID='$id'"); 
            mysql_query("DELETE FROM allergies WHERE personID='$id'");                     
            mysql_query("DELETE FROM journal WHERE personID='$id'");              
            
            $query = mysql_query("Select * from mappings");
            while($row = mysql_fetch_array($query))
            {
                $mid = $row['mappingID'];
                for($i = 1; $i < 10; $i++)
                {
                    // Remove personID user desires to delete from all accounts
                    $colName = $i.'_personID';                       
                    if($row[$colName] == $temp*(-1)) 
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
        header("location:myportal.php");
    }
?>