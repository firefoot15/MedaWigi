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
    
    // Move personIDs to array    
    $idArray = array();    
    for($i = 0; $i < 10; $i++)
    {
        $colName = $i.'_personID';
        if($row[$colName] != 0)
            array_push($idArray, $row[$colName]);  
    }  

    mysql_query("DELETE FROM mappings WHERE accountID = '$accountID'");  
    mysql_query("INSERT INTO mappings (accountID, 0_personID) VALUES ('$accountID','$idArray[0]')");

	// Get personID of profile user desires to delete
	if($_SERVER['REQUEST_METHOD'] == "GET")    
	{
        $id = $_GET['id'];
        $temp;
        for($j = 1, $k =1; $j < count($idArray); $j++)
        {            
            // Insert personIDs user does not desire to delete. 
            if(abs($idArray[$j]) != $id)
            {   
                switch($k)
                {
                    case 1: 
                        mysql_query("UPDATE mappings SET 1_personID='$idArray[$j]' WHERE accountID = '$accountID'"); 
                        break;
                    case 2:
                        mysql_query("UPDATE mappings SET 2_personID='$idArray[$j]' WHERE accountID = '$accountID'"); 
                        break;
                    case 3:
                        mysql_query("UPDATE mappings SET 3_personID='$idArray[$j]' WHERE accountID = '$accountID'"); 
                        break;
                    case 4:
                        mysql_query("UPDATE mappings SET 4_personID='$idArray[$j]' WHERE accountID = '$accountID'"); 
                        break;
                    case 5:
                        mysql_query("UPDATE mappings SET 5_personID='$idArray[$j]' WHERE accountID = '$accountID'"); 
                        break;
                    case 6:
                        mysql_query("UPDATE mappings SET 6_personID='$idArray[$j]' WHERE accountID = '$accountID'"); 
                        break;     
                    case 7:
                        mysql_query("UPDATE mappings SET 7_personID='$idArray[$j]' WHERE accountID = '$accountID'"); 
                        break;
                    case 8:
                        mysql_query("UPDATE mappings SET 8_personID='$idArray[$j]' WHERE accountID = '$accountID'"); 
                        break;
                    case 9:
                        mysql_query("UPDATE mappings SET 9_personID='$idArray[$j]' WHERE accountID = '$accountID'"); 
                        break;    
                }
                $k++;
                /////////////////// the mappings table is correct regardless ////////////////////////////
                
            }
            
            else
            {
                // Preserve signed value
                $temp = $idArray[$j];  
            }

            // If negative, linked account -> journal?           
            if($temp < 0)
            {
                mysql_query("DELETE FROM journal WHERE accountID = '$accountID'"); 
            }
            
            // Else remove from all tables using personIDs           
            else 
            {
                mysql_query("DELETE FROM persons WHERE personID='$id'");
                mysql_query("DELETE FROM allergies WHERE personID='$id'");                     
                mysql_query("DELETE FROM journal WHERE personID='$id'");                  
            }
                
                // need to check zero case, should not occur?

                
                ?>
        		<th>Welcome <?php echo $temp;?>!</th></br></br>
    </center></body></html>
        <?php
                
        }
    }
?>
<!--WHAT HAPPENS IN ZERO CASE? Zero case will never occur. Check journal outcomes.// Update server for journal table.

            

  
            }   
        }  		
		//header("location:myportal.php");
	}*/
?>