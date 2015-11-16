<html>
	<head>
		<title>Reset Password</title>
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
		<?php
        include 'connect.php';
        
        session_start();
        
		$passError = $confirmPassError = "";
		$password = $confirmPass = "";

		if($_SERVER["REQUEST_METHOD"]=="POST") {
			if(empty($_POST["password"])) {
				$passError = "Please enter a new password.";
			}

			if(empty($_POST["confirmPass"])) {
				$confirmPassError = "Please confirm the new password.";
			}
            if($_SESSION['id']){
			     }


			else {
				$password = mysql_real_escape_string($_POST['password']);
				$confirmPass = mysql_real_escape_string($_POST['confirmPass']);
				$email = isset($_GET['sessionEmail']) ? $_GET['sessionEmail']:'';
                
                if(!empty($_GET['sessionEmail'])) {$_SESSION['sessionEmail']=$email;}

				$query = mysql_query("SELECT * from accounts WHERE email='$email'");
				
                $exists = mysql_num_rows($query);
                if($exists >0) {
                    while($row = mysql_fetch_assoc($query)){
                        $table_users = $row['email'];
                        if($email == $table_users) {
                            $query2 = mysql_query("UPDATE accounts SET password=$password");
                        }
                    }
                }

				

			}
		}


		?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			New Password: <input type="text" name="password" value="<?php echo $password;?>"/>
			<span class="error">* <?php echo $passError;?></span><br/>
			Confirm Password: <input type"text" name="confirmPass" value="<?php echo $confirmPass;?>"/>
			<span class="error">* <?php echo $confirmPassError;?></span><br/>
			<input type="button" name"cancel" value="Cancel" />
			<input type="submit" name="submit" value="Submit"/>
		</form>
		<span class="error">* Required field.</span>
	</body>
</html>