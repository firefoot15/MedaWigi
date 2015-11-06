<html>
	<head>
		<title>Reset Password</title>
		<style>
		.error {color: #FF0000;}
		</style>
	</head>
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