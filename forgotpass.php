<?php
include 'connect.php';
session_start();
$userEmail = "";

if(isset($_POST['submitEmailButton'])){
    $email = mysql_real_escape_string($_POST['emailForm']);
    $_SESSION['email']= $email;
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
    $userEmail = $_SESSION['email'];
    $secretAnswerCorrectBool = true;
        
    
    //Grab correct secretAnswer
    $secretAnswerQuery = mysql_query("SELECT * from accounts WHERE email='$userEmail'");
    $row = mysql_fetch_array($secretAnswerQuery);
    $userSecretAnswer = $row['answerQuest'];
 
    //If query returned correct
    if(mysql_numrows($secretAnswerQuery) !=0){
        if($secretAnswer === $userSecretAnswer){
            $secretAnswerCorrectBool = true;
            $tempPassword = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
            $updatePasswordQuery = mysql_query("UPDATE accounts SET password = '$tempPassword' WHERE email = '$userEmail'");
            
            //Set up the email variables
            $headline = "Your Temporary Password!";
            $message = "Here is your temporary password!: '$tempPassword', please change your password upon your next log in!";
            $from = "medawigi@gmail.com";
            $headers = "From:" .$from;
            
            //mail($userEmail, $headline, $message, $headers);
            
            //Alert letting the user know the temp password was sent to their email
            Print'<script>alert("An email containing your temporary password has been sent!");</script>';
            Print '<script>window.location.assign("index.php");</script>';
        }
        else{
            $secretAnswerCorrectBool = false;
            Print'<script>alert("The entered secret answer is not correct!");</script>';
            Print '<script>window.location.assign("forgotpass.php");</script>';
        }
    }
    else{
        $sercetAnswerCorrectBool = false;
         Print'<script>alert("The entered secret answer is not correct!");</script>';
         Print '<script>window.location.assign("forgotpass.php");</script>';  
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
                    <li id="home"><a href="index.php">Home</a></li>
                    <br>
                    <li id="contact"><a href="contact.html">Contact us</a></li>
                    <br>
                </ul>
            </div>
        </div>

    </div>


    <body>
        <center>
            <h1>Forgot Your Password?</h1>
            <br/>
            <form id="emailCheck" action="forgotpass.php" method="POST">
                Email:
                <input type="email" id="email" name="emailForm" required="required" />
                <input type="submit" name="submitEmailButton" value="Submit" class="basic_button" />
                <input type="reset" name="cancel" value="Cancel" onclick="document.location.href='index.php'" class="basic_button" />
            </form>
            <br/>
            <br/>
            <form id="secretCheck" action="forgotpass.php" method="POST">
                <?php
                if(isset($secretQuest)){
                    echo $secretQuest.": ";
                    echo '<input type="text" id="secretAnswer" name="secretAnswerForm" required="required" />';
                    echo '<input type="submit" name="secretQuestionSubmitButton" value="Submit" class="basic_button" />';
                }
                ?>
            </form>
        </center>
    </body>

    </html>