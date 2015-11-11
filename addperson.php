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
$bool = true;

//Global variable to count number of people being added
$personNumber

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
        $query = mysql_query("Select accountID from accounts WHERE username = '$user'");
        $accountID = mysql_result($query, 0); 
        $queryTwo = mysql_query("SELECT * from mappings where accountID = '$accountID'");
        if($bool)
        {
            mysql_query("INSERT INTO persons (firstName, lastName, nickname) VALUES ('$firstName','$lastName','$nickname')");
            //Auto incremented value stored in variable
            $personID = mysql_insert_id();
            
            //Array to store personID
            $personIdArray =  array();
            for($i = 0; $i < 10; $i++)
            {
                $$colName = $i.'_personID';
                
            }
            
            //Go into mappings and store personID into appropriate column where row = accountID of current session. 
            //Need to store into column x_personID where x is the person (always > 0) because 0_personID is the user
            //How should I specify the number?
            mysql_query("INSERT INTO mappings WHERE accountID = '$accountID'  (_personID) VALUES ('$personID')");
            
            
            Print '<script>alert("The new person was successfully added!");</script>';
            Print '<script>window.location.assign("myportal.php");</script>';
            
        }
    }
?>

