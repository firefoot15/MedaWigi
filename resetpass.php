<html>
	<head>
		<title>Reset Password</title>
		<style>
		.error {color: #FF0000;}
		</style>
	</head>
	<body>
		<?php
		$passError = $confirmPassError = "";
		$password = $confirmPass = "";

		if($_SERVER["REQUEST_METHOD"]=="POST") {
			if(empty($_POST["password"])) {
				$passError = "Please enter a new password.";
			}

			if(empty($_POST["confirmPass"])) {
				$confirmPassError = "Please confirm the new password.";
			}

			if($_POST["cancel"]) {
				header("location: index.php");
			}

			else {
				$password = mysql_real_escape_string($_POST['password']);
				$confirmPass = mysql_real_escape_string($_POST['confirmPass']);
				$email = mysql_real_escape_string($_POST['email']);
				$bool = true;

				mysql_connect("localhost", "root", "") or die(mysql_error());
				mysql_select_db("medawigi") or die("Cannot connect to database.");
				$query = mysql_query("SELECT * from accounts WHERE email='$email'");
				$table_emails = "";

				while($row = mysql_fetch_assoc($query)) {
					$table_emails = $row['email'];
					
					if($email == $table_emails) {
						Print'<script>alert("The password is reset.");</script>';
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
			<input type="submit" name"cancel" value="Cancel"/>
			<input type="submit" name="submit" value="Submit"/>
		</form>
		<span class="error">* Required field.</span>
	</body>
</html>