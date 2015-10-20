<html>
    <head>
        <title>Forgot Your Password</title>
    </head>
    <body>
        <h2>Forgot Your Password?</h2><br/>
        <form id="emailcheck" action="forgotpass.php" method="POST">
            Email: <input type="text" id="email" name="email" required="required"/>
                   <input type="submit" name="submit" />
                   <input type="button" name="cancel" value="Cancel" onclick="document.location.href='index.php'"/>
        </form><br/>
    </body>    
</html>

<?php
//if($_SERVER["REQUEST_METHOD"] == "POST"){
if(isset($_POST['submit'])){
//    $requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
//    if ($requestMethod == 'post') {  
    $email = mysql_real_escape_string($_POST['email']);
    $bool = true;
    mysql_connect("localhost", "root","") or die(mysql_error());
    mysql_select_db("medawigi") or die("Cannot connect to database");
    $query = mysql_query("SELECT * from accounts WHERE email ='$email'");
    $exists = mysql_num_rows($query);//checking to see if email exists
    if($exists > 0)
    {
        while($row = mysql_fetch_assoc($query))
        {            
            $table_users = $row['email'];
            if($email == $table_users)
            {
                $bool = false;
                Print'<script>alert("This email is currently in use!");</script>';
            }
            else{
                Print'<script>alert("This email is currently not in use");</script>';
            }
        }
        
    }      
}
?>