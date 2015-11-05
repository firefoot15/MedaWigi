<html>
    <head> 
    <title>Add A Person</title>
    </head>
    <body>
        <h3>Add a New Person To Your Account!</h3>
        <input type="button" name="registereduserbutton" value="Registered User?" onclick="showRegisteredUserForm()"/>
        <input type="button" name ="newpersonbutton" value="New Person?" onclick="showNewPersonForm()"/>
        <br/><br/>
        <form action="addperson.php" id="newRegisteredUser" name="newRegisteredUserForm" style="display:none;" method="POST">
            Email: <input type="text" name="newRegisteredUserText"/><br/><br/>  
            <input type="button" name="submitRegisteredUserButton" value="Add"/>
            <input type="reset" name="cancelRegisteredUserButton" value="Cancel" onclick="hideRegisteredUserForm()"/>
            
        </form>
        
        <form action ="addperson.php" id="newPerson" name="NewPersonForm" style="display:none;" method="POST">
            Nickname*: <input type="text" name="nicknameText"/><br/><br/>
            First Name: <input type="text" name="firstNameText"/><br/><br/>
            Last Name: <input type="text" name="lastNameText"/><br/><br/>
            <input type="button" name="submitNewPersonButton" value="Add"/>
            <input type="reset" name="cancelNewPersonButton" value="Cancel" onclick="hideNewPersonForm()"/>
            
        </form>
        
    </body>
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
?>