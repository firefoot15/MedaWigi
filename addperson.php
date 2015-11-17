<?php
session_start();
include 'connect.php';
?>

<html>

	<head>
    <title>Add Person</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<script src="medawigi.js"></script>
	</head>
<div class="top">
  <div id="logo">
    <img src="http://medawigi.no-ip.org/images/logo.png";/>
  </div>
  <div class="sammich">
    <img onclick="menu()" class="sammich" src="http://medawigi.no-ip.org/images/sammich-white.png" />
    <div class="menu">
      <ul id="menu-list">
        <li id="home"><a href="personhome.php">Home</a></li>
        <li id="insurance_contact"><a href="insurance.php">Insurance</a></li>
        <li id="calendar"><a href="calendar.php">Calendar</a></li>
        <li id="journal"><a href="journal.php">Journal</a></li>
        <li id="medications"><a href="medications.php">Medications</a></li>
        <li id="allergies"><a href="allergies.php">Allergies</a></li>
	<li id="immunizations"><a href="immunizations.php">Immunizations</a></li>
	<li id="contacts"><a href="contacts.php">Contacts</a></li>
	<li id="conditions"><a href="conditions.php">Conditions</a></li>
        <li id="contact"><a href="contact.html">Contact us</a></li>
        <li id="editprofile"><a href="editprofile.php">Edit Profile</a></li>
        <li id="switch_profile"><a href="personhome.php">Switch Profile</a></li>
        <li id="logout"><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</div>
<div class="wrapper"></div>

<body>
    <h2>ADD PERSON</h2>
    <div class="wrapper">
    <table class="page_table"><tr><td></td><td><center>
        <h1>Add New People!</h1>
            
        <input type="button" name="goback" value="Cancel" onclick="document.location.href='myportal.php'" class="basic_button" />
        <input type="button" name="registereduserbutton" value="Registered User?" onclick="showRegisteredUserForm()" class="basic_button" />
        <input type="button" name="newpersonbutton" value="New Person?" onclick="showNewPersonForm()" class="basic_button" />
        
        <br/>
        <br/>
        <form action="addperson.php" id="newRegisteredUser" name="newRegisteredUserForm" style="display:none;" method="POST">
            Email:
            <input type="text" name="newRegisteredUserText" />
            <br/>
            <br/>
            <input type="reset" name="cancelRegisteredUserButton" value="Cancel" onclick="hideRegisteredUserForm()" class="basic_button" />
            <input type="submit" name="submitRegisteredUserButton" value="Add" class="basic_button" />
            
        </form>

        <form action="addperson.php" id="newPerson" name="NewPersonForm" style="display:none;" method="POST">
            Nickname*:
            <input type="text" name="nicknameText" />
            <br/>
            <br/> First Name:
            <input type="text" name="firstNameText" />
            <br/>
            <br/> Last Name:
            <input type="text" name="lastNameText" />
            <br/>
            <br/>
            <input type="reset" name="cancelNewPersonButton" value="Cancel" onclick="hideNewPersonForm()" class="basic_button" />
            <input type="submit" name="submitNewPersonButton" value="Add" class="basic_button" />
            
        </form>
    </center></td></tr></table>
</div></body>

</html>

<script>
    function showRegisteredUserForm() {
        document.getElementById('newRegisteredUser').style.display = "block";
    }
    function showNewPersonForm() {
        document.getElementById('newPerson').style.display = "block";
    }
    function hideRegisteredUserForm() {
        document.getElementById('newRegisteredUser').style.display = "none";
    }
    function hideNewPersonForm() {
        document.getElementById('newPerson').style.display = "none";
    }
</script>

<?php
//Boolean to enter switch statement
$switchBool = false;
//Boolean to flag if user adding their own account as linked person
$sameUserBool = false;
//Boolean to flag is registered user is already linked to account attempting add
$userAlreadyLinkedBool = false;
//Boolean to flag if email of user posted is not stored in DB
$emailDoesNotExistBool = false;
//Check to see if user is the same
if($_SESSION['user']){}
		else{
			header("location:index.php");
        }
//Store username that's logged in        
$user = $_SESSION['user'];
    //If adding on a registered user
    if(isset($_POST['submitRegisteredUserButton'])){
        
        //Store posted email address
        $email = mysql_real_escape_string($_POST['newRegisteredUserText']);
        
        //Query to grab account ID for registered user that is being added onto account as a person
        $registeredUserQuery = mysql_query("Select accountID from accounts WHERE email = '$email'") or die(mysql_error());
        
        //If query failed and no accountID is stored, email does not exist
        if(mysql_numrows($registeredUserQuery) == 0){
            $emailDoesNotExistBool = true;
        }
        
        else{
        //Query successful, store account ID        
        $registeredUserAccountID = mysql_result($registeredUserQuery, 0);
            
        //Store accountID of user that is logged in and adding on a new registered user as a person
        $accountQuery = mysql_query("Select accountID from accounts WHERE username = '$user' limit 1");
        $accountID = mysql_result($accountQuery,0);
        
        //Store personID of user that is logged in and adding on a new registered user as a person
        $personQuery = mysql_query("Select 0_personID from mappings WHERE accountID = '$accountID'");
        $personID = mysql_result($personQuery,0);
        
        //Store personID of registered user that is being added onto account as a person
        $newRegisteredPersonQuery = mysql_query("Select 0_personID from mappings WHERE accountID = '$registeredUserAccountID'");
        $newRegisteredPersonID = mysql_result($newRegisteredPersonQuery, 0) * -1;
        
        //Query for correct row in mappings
        $mappingsQuery = mysql_query("SELECT * from mappings where accountID = '$accountID'");
        $row = mysql_fetch_array($mappingsQuery);
        
        //Check to see if user is trying to add themselves
        if($accountID == $registeredUserAccountID)
        {
            $sameUserBool = true;
        }
        
        //i starts at 1 and goes to 10 since 9 people can be added 
        for($i = 1; $i < 10 && $switchBool == false && $sameUserBool == false && $emailDoesNotExistBool == false; $i++)  
            {
                $colName = $i.'_personID';
            
                    //While that SQL cell is empty/set to 0
                    if($row[$colName] == 0)
                    {
                        $switchBool = true;
                        $sameUserBool = false;
                        $emailDoesNotExistBool = false;
                        switch($i)
                        {
                            case 1:
                                mysql_query("UPDATE mappings SET 1_personID = '$newRegisteredPersonID' WHERE accountID ='$accountID'");
                                break;
                            case 2:
                                mysql_query("UPDATE mappings SET 2_personID = '$newRegisteredPersonID' WHERE accountID ='$accountID'");
                                break;
                            case 3:
                                mysql_query("UPDATE mappings SET 3_personID = '$newRegisteredPersonID' WHERE accountID ='$accountID'");
                                break;
                            case 4:
                                mysql_query("UPDATE mappings SET 4_personID = '$newRegisteredPersonID' WHERE accountID ='$accountID'");
                                break;
                            case 5:
                                mysql_query("UPDATE mappings SET 5_personID = '$newRegisteredPersonID' WHERE accountID ='$accountID'");
                                break;
                            case 6:
                                mysql_query("UPDATE mappings SET 6_personID = '$newRegisteredPersonID' WHERE accountID ='$accountID'");
                                break;
                            case 7:
                                mysql_query("UPDATE mappings SET 7_personID = '$newRegisteredPersonID' WHERE accountID ='$accountID'");
                                break;
                            case 8:
                                mysql_query("UPDATE mappings SET 8_personID = '$newRegisteredPersonID' WHERE accountID ='$accountID'");
                                break;
                            case 9:
                                mysql_query("UPDATE mappings SET 9_personID = '$newRegisteredPersonID' WHERE accountID ='$accountID'");
                                break;    
                        }
                        
                    }
                }
    
        //Alert successful add and move to myportal
        if($sameUserBool == false && $emailDoesNotExistBool == false){
        Print '<script>alert("The new person was successfully added!");</script>';
        Print '<script>window.location.assign("myportal.php");</script>';
        }
        
        //Alert if user trying to add their own account
        if($sameUserBool == true)
        {
            Print'<script>alert("You cannot add yourself to your own account!");</script>';
            Print '<script>window.location.assign("myportal.php");</script>';
        }
        }
        
        //Alert if email is not in db
        if($emailDoesNotExistBool == true)
        {
            Print'<script>alert("This email is not currently registered!");</script>';
            Print '<script>window.location.assign("myportal.php");</script>';
        }
    }
    
    //If adding on a new person
    if(isset($_POST['submitNewPersonButton'])){
        $nickname = mysql_real_escape_string($_POST['nicknameText']);
        $firstName = mysql_real_escape_string($_POST['firstNameText']);
        $lastName = mysql_real_escape_string($_POST['lastNameText']);
        
        //Grab and store accountID
        $accountQuery = mysql_query("Select accountID from accounts WHERE username = '$user' limit 1");
        $accountID = mysql_result($accountQuery, 0);
        
        //Take row in mappings table for user's accountID, store in row var
        $mappingsQuery = mysql_query("SELECT * from mappings where accountID = '$accountID'");
        $row =  mysql_fetch_array($mappingsQuery);
        
        //Query to insert into persons table
        $newProfilePic = "images/profilepic".rand(1, 16).".png";
        mysql_query("INSERT INTO persons (firstName, lastName, gender, race, nickname, profilepic) VALUES ('$firstName','$lastName', 'Unspecified', 'Unspecified','$nickname', '$newProfilePic')");
        //Auto incremented value stored in variable
        $personID = mysql_insert_id();
                //Switch statement that inserts into specified column
                for($i = 1; $i < 10 && $switchBool == false; $i++)
                {
                    $colName = $i.'_personID';
                    //While that SQL cell is empty/set to 0
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
