<?php
include 'connect.php';
session_start();
if(isset($_POST['submitEmailButton'])){
    $email = mysql_real_escape_string($_POST['email']);
    $emailDoesNotExistBool = false;
    
    //Grab the secret question based off of email
    $secretQuestQuery = mysql_query("SELECT secretQuest from accounts WHERE email ='$email' limit 1");
    
    if(mysql_numrows($secretQuestQuery) !=0){
        $emailDoesNotExistBool = false;
        $secretQuest = mysql_result($secretQuestQuery,0);
    }
    else{
        $emailDoesNotExistBool = true;
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
    <h1>Forgot Your Password?</h1>
    <br/>
    <form id="emailcheck" action="forgotpass.php" method="POST">
        Email:
        <input type="text" id="email" name="email" required="required" />
        <input type="submit" name="submitEmailButton" value="Submit" onclick="showSecretCheckForm();" class="basic_button" />
        <input type="reset" name="cancel" value="Cancel" onclick="document.location.href='index.php'" class="basic_button" />
    </form>
    <br/>
    <br/>

    <form action="forgotpass.php" id="secretcheck" action="forgotpass.php" style="display:none;" method="POST">
        <?php
        echo $secretQuest;
        ?>
        <input type="text" id="secretQuestionForm" name="secretQuestionForm" required="required" />
        <input type="submit" name="secretQuestionSubmitButton" value="Submit" class="basic_button"/>
        <input type="reset" name="secretQuestionCancelButton" value="Cancel" class="basic_button" onclick="document.location.href='index.php'" />
    </form>
</body>

</html>

<script>
    function showSecretCheckForm(){
        document.getElementById('secretCheck').style.display = "block";
    }
    
    function hideSecretCheckForm(){
        document.getElementById('secretCheck').style.display = "block";
    }
    
    function showEmailCheckForm(){
        document.getElementById('emailCheck').show.display = "block";
}
    
    function hideEmailCheckForm(){
        document.getElementById('emailcheck').show.display = "none";
    }
</script>

<?php
//if($_SERVER["REQUEST_METHOD"] == "POST"){
include 'connect.php';
session_start();
if(isset($_POST['submit'])){
//    $requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
//    if ($requestMethod == 'post') {  
    $email = mysql_real_escape_string($_POST['email']);
    $sessionEmail = $_SESSION['email'];
    $bool = true;
    
    $query = mysql_query("SELECT * from accounts WHERE email ='$email'");
    $exists = mysql_num_rows($query);
    if($exists > 0)
    {
        while($row = mysql_fetch_assoc($query))
        {            
            $table_users = $row['sessionEmail'];
            if($sessionEmail == $table_users)
            {
                Print'<script>alert("This email is currently in use!");</script>';
            }
            else{
                $bool = false;
                if(!$bool){
                Print'<script>alert("This email is currently not in use");</script>';
                }
            }
        }
        
    }      
}
?>