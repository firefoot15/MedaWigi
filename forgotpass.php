<?php
include 'connect.php';
session_start();
$userEmail = "";
if(isset($_POST['submitEmailButton'])){
    $email = mysql_real_escape_string($_POST['emailForm']);
    $userEmail = $email;
    $emailDoesNotExistBool = false;
    
    //Grab the secret question based off of email
    $secretQuestQuery = mysql_query("SELECT secretQuest from accounts WHERE email ='$email'");
    
    //Validation
    if(mysql_numrows($secretQuestQuery) !=0){
        $emailDoesNotExistBool = false;
        $secretQuest = mysql_result($secretQuestQuery,0);
    }
    else{
        $emailDoesNotExistBool = true;
         Print'<script>alert("This email is not currently registered!");</script>';
         Print '<script>window.location.assign("forgotpass.php");</script>';
        
    }
}

//Validate secret answer
if(isset($_POST['secretQuestionSubmitButton'])){
    $secretAnswer = mysql_real_escape_string($_POST['secretAnswerForm']);
    $secretAnswerCorrectBool = false;
        
    
    //Grab correct secretAnswer
    $secretAnswerQuery = mysql_query("SELECT answerQuest from accounts WHERE email='$userEmail'");
    
    if(mysql_numrows($secretAnswerQuery) !=0){
        $userSecretAnswer = mysql_result($secretAnswerQuery,0);
        if($secretAnswer == $userSecretAnswer){
            //Email Logic here
        }
        else{
            $secretAnswerCorrectBool = true;
        }
    }
    else{
        $sercetAnswerCorrectBool = true;
    }
}
?>

    <html>

    <head>
        <title>Forgot Your Password?</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <script src="medawigi.js"></script>
    </head>
    <div class="top">
        <div id="logo">
            <img />

        </div>
        <div class="sammich">
            <img onclick="menu()" class="sammich" src="https://cdn2.iconfinder.com/data/icons/menu-elements/154/round-border-menu-bar-128.png" />



            <div class="menu">
                <ul id="menu-list">
                    <br>
                    <li id="home"><a href="personhome.php">Home</a></li>
                    <br>
                    <li id="insurance_contact"><a href="insurance.php">Insurance</a></li>
                    <br>
                    <li id="calendar"><a href="calendar.php">Calendar</a></li>
                    <br>
                    <li id="journal"><a href="journal.php">Journal</a></li>
                    <br>
                    <li id="medications"><a href="medication.php">Medications</a></li>
                    <br>
                    <li id="allergies"><a href="allergies.php">Allergies</a></li>
                    <br>
                    <li id="immunizations"><a href="immunizations.php">Immunizations</a></li>
                    <br>
                    <li id="contacts"><a href="contacts.php">Contacts</a></li>
                    <br>
                    <li id="conditions"><a href="conditions.php">Conditions</a></li>
                    <br>
                    <li id="contact"><a href="contact.html">Contact us</a></li>
                    <br>
                    <li id="editprofile"><a href="editprofile.php">Edit Profile</a></li>
                    <br>
                    <li id="switch_profile"><a href="#">Switch Profile</a></li>
                    <br>
                    <li id="logout"><a href="logout.php">Logout</a></li>
                    <br>
                </ul>
            </div>
        </div>

    </div>


    <body>
        <center>
            <h1>Forgot Your Password?</h1>
            <br/>
            <form id="emailCheck" action="forgotpass.php" method="POST" >
                Email:
                <input type="email" id="email" name="emailForm" required="required" />
                <input type="submit" name="submitEmailButton" value="Submit" class="basic_button" onclick="showSecretCheckForm()"  />
                <input type="reset" name="cancel" value="Cancel" onclick="document.location.href='index.php'" class="basic_button" />
            </form>
            <br/>
            <br/>
            <form action="forgotpass.php" id="secretCheck" action="forgotpass.php" style="display:none;" method="POST">
                <?php
                if(isset($secretQuest)){
                    echo $secretQuest;
                }
                ?>
                    <input type="text" id="secretAnswer" name="secretAnswerForm" required="required" />
                    <input type="submit" name="secretQuestionSubmitButton" value="Submit" class="basic_button" />
                    <input type="reset" name="secretQuestionCancelButton" value="Cancel" class="basic_button" onclick="document.location.href='index.php'" />
            </form>
        
    </body>

    </html>

    <script>
        function showSecretCheckForm() {
            document.getElementById('secretCheck').style.display = "block";
        }
        function hideSecretCheckForm() {
            document.getElementById('secretCheck').style.display = "none";
        }
        function showEmailCheckForm() {
            document.getElementById('emailCheck').style.display = "block";
        }
        function hideEmailCheckForm() {
            document.getElementById('emailcheck').style.displayS = "hidden";
        }
    </script>