<html>
	<head> 
		<title> MedaWiGi</title>
<link rel="stylesheet" type="text/css" href="style.css">
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
		<h1> MedaWiGi</h1>
		<img src="http://tomshattuck.typepad.com/.a/6a01538f4b955c970b017ee8bf71a8970d-pi" 
		style="width: 300px; height 500px;">

		<br/>


		<form action="checklogin.php" method="POST">
		Username:<input type="text" name="username" required="required" PLACEHOLDER="Enter your Username"/> <br/>
		Password: <input type="password" name="password" required="required" PLACEHOLDER="Enter your password"/> <br/>

			<a href="register.php">New User?</a> <br/>
			<a href="forgotpass.php"> Forgot Password?</a> <br/>

			<input type="submit" value="Login" />
		</form>
		
		</center>

</body>
</html>
