<html>
	<head> 
		<title> MedaWiGi</title>

</head>
	<body>
		<center>
		<h1> MedaWiGi</h1>
		<img src="http://tomshattuck.typepad.com/.a/6a01538f4b955c970b017ee8bf71a8970d-pi" 
		style="width: 300px; height 500px;">

		<br/>


		<form action="checklogin.php" method="POST">
			Enter Username:<input type="text" name="username" required="required" PLACEHOLDER="Enter your Username"/> <br/>
			Enter Password: <input type="password" name="password" required="required" PLACEHOLDER="Enter your password"/> <br/>

			<a href="register.php">New User?</a> <br/>
			<a href="forgotpass.php"> Forgot Password?</a> <br/>

			<input type="submit" value="Login" />
		</form>
		
		</center>

</body>
</html>
