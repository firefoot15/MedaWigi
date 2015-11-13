<html>
    <head> 
    <title>Add A Person</title>
    <link rel="stylesheet" type="text/css" href="style.css">    
    </head>
    <div class="wrapper"></div>
    <body><center>
        <h1>Add New People!</h1>
        <h3>Add Person</h3>
        <input type="button" name="registereduserbutton" value="Registered User?" onclick="showRegisteredUserForm()" class="basic_button"/>
        <input type="button" name="newpersonbutton" value="New Person?" onclick="showNewPersonForm()" class="basic_button"/>
        <input type="button" name="goback" value="Go back" onclick="document.location.href='myportal.php'" class="basic_button"/>
        <br/><br/>
        <form action="addperson.php" id="newRegisteredUser" name="newRegisteredUserForm" style="display:none;" method="POST">
            Email: <input type="text" name="newRegisteredUserText"/><br/><br/>  
            <input type="submit" name="submitRegisteredUserButton" value="Add" class="basic_button"/>
            <input type="reset" name="cancelRegisteredUserButton" value="Cancel" onclick="hideRegisteredUserForm()" class="basic_button"/>  
        </form>
        
        <form action ="addperson.php" id="newPerson" name="NewPersonForm" style="display:none;" method="POST">
            Nickname*: <input type="text" name="nicknameText"/><br/><br/>
            First Name: <input type="text" name="firstNameText"/><br/><br/>
            Last Name: <input type="text" name="lastNameText"/><br/><br/>
            <input type="submit" name="submitNewPersonButton" value="Add" class="basic_button"/>
            <input type="reset" name="cancelNewPersonButton" value="Cancel" onclick="hideNewPersonForm()" class="basic_button"/>
        </form>
    </center></body>
</html>

<script>
    function showRegisteredUserForm(){
        document.getElementById('newRegisteredUser').style.display="block";
        }
    
    function showNewPersonForm(){
        document.getElementById('newPerson').style.display="block";
    }
    
    function hideRegisteredUserForm(){
        document.getElementById('newRegisteredUser').style.display="none";
    }
    
    function hideNewPersonForm(){
        document.getElementById('newPerson').style.display="none";
    }
</script>

<?php
include 'connect.php';
session_start();
$switchBool = false;

//Global variable to count number of people being added
$personNumber;

//Check to see if user is the same
if($_SESSION['user']){}
		else{
			header("location:index.php");
        }

//Store username that's logged in        
$user = $_SESSION['user'];
    
//SQL Operations
//Adding the person onto the account that is logged in
    
    //If adding on a registered user
    if(isset($_POST['submitRegisteredUserButton'])){
        $email = mysql_real_escape_string($_POST['newRegisteredUserText']);
        $queryOne = mysql_query("Select * from accounts WHERE username = '$user'");
        $queryTwo = mysql_query("Select * from accounts WHERE email = '$email'");
    }
    
    //If adding on a new person
    if(isset($_POST['submitNewPersonButton'])){
        $nickname = mysql_real_escape_string($_POST['nicknameText']);
        $firstName = mysql_real_escape_string($_POST['firstNameText']);
        $lastName = mysql_real_escape_string($_POST['lastNameText']);
        
        //Grab and store accountID
        $query = mysql_query("Select accountID from accounts WHERE username = '$user' limit 1");
        $accountID = mysql_result($query, 0);
        
        //Take row in mappings table for user's accountID, store in row var
        $queryTwo = mysql_query("SELECT * from mappings where accountID = '$accountID'");
        $row =  mysql_fetch_array($queryTwo);
        
        
            //Query to insert into persons table
            mysql_query("INSERT INTO persons (firstName, lastName, gender, race, nickname) VALUES ('$firstName','$lastName', 'Unspecified', 'Unspecified','$nickname')");
            //Auto incremented value stored in variable
            $personID = mysql_insert_id();
//            echo "<script type='text/javascript'>alert('$personID');</script>";
            
            

                //Switch statement that inserts into specified column....hopefully
                for($i = 1; $i < 10 && $switchBool == false; $i++)
                {
                    //$row[$colName] == 0
                    $colName = $i.'_personID';
                    //What needs to be added here?
                    if($row[$colName] == 0)
                    {
                        $switchBool = true;
                        switch($i)
                        {
                            case 1:
                                mysql_query("UPDATE mappings SET 1_personID = '$personID' WHERE accountID ='$accountID'");
                                break;
                            case 2:
                                mysql_query("UPDATE mappings SET 2_personID = '$personID' WHERE accountID ='$accountID'");
                                break;
                            case 3:
                                mysql_query("UPDATE mappings SET 3_personID = '$personID' WHERE accountID ='$accountID'");
                                break;
                            case 4:
                                mysql_query("UPDATE mappings SET 4_personID = '$personID' WHERE accountID ='$accountID'");
                                break;
                            case 5:
                                mysql_query("UPDATE mappings SET 5_personID = '$personID' WHERE accountID ='$accountID'");
                                break;
                            case 6:
                                mysql_query("UPDATE mappings SET 6_personID = '$personID' WHERE accountID ='$accountID'");
                                break;
                            case 7:
                                mysql_query("UPDATE mappings SET 7_personID = '$personID' WHERE accountID ='$accountID'");
                                break;
                            case 8:
                                mysql_query("UPDATE mappings SET 8_personID = '$personID' WHERE accountID ='$accountID'");
                                break;
                            case 9:
                                mysql_query("UPDATE mappings SET 9_personID = '$personID' WHERE accountID ='$accountID'");
                                break;    
                        }
                        
                    }
                }
                                   
            //Alert successful add and move to myportal
            Print '<script>alert("The new person was successfully added!");</script>';
            Print '<script>window.location.assign("myportal.php");</script>';
            
        
    }
?>

