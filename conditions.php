<!--    CONDITIONS PAGE
        Displays a list of all conditions associated with personID.
 -->

		<?php
        include 'connect.php';
		session_start();
		if($_SESSION['user']){ }
		else{
			header("location:index.php");}

		if($_SESSION['id']){ }
		else{
			header("location:myportal.php");}

		$user = $_SESSION['user'];
		$id = $_SESSION['id'];
        ?>

            <!-- View conditions form-->
<html>
	<head>
		<title>Conditions</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<script src="medawigi.js"></script>
	</head>
<div class="top">
  <div id="logo">
    <img src="http://medawigi.no-ip.org/images/logo.png";/>
  </div>
  <div class="sammich">
    <img onclick="menu()" class="sammich" src="http://medawigi.no-ip.org/images/sammich-white.png" />
    <div class="menu">
      <ul id="menu-list">
        <li id="home"><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>">Home</a></li>
        <li id="insurance_contact"><a href="insurance.php">Insurance</a></li>
        <li id="calendar"><a href="calendar.php">Calendar</a></li>
        <li id="journal"><a href="journal.php">Journal</a></li>
        <li id="medications"><a href="medications.php">Medications</a></li>
        <li id="allergies"><a href="allergies.php">Allergies</a></li>
	<li id="immunizations"><a href="immunizations.php">Immunizations</a></li>
	<li id="contacts"><a href="contacts.php">Contacts</a></li>
	<li id="conditions"><a href="conditions.php">Conditions</a></li>
        <li id="contact"><a href="contact.html">Contact us</a></li>
        <li id="editprofile"><a href="editperson.php">Edit Profile</a></li>
        <li id="switch_profile"><a href="myportal.php">Switch Profile</a></li>
        <li id="logout"><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</div>
	<body>
		<h2>CONDITIONS</h2>
        <div class="wrapper">   
        <table class="page_table"><tr><td></td><td><center>    
        <h1>Conditions</h1>    
        <table class="table3">
			<tr>
				<th align="left">Name</th>
				<th>Description</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php
            
			$query = mysql_query("Select * from conditions WHERE personID = '$id'");
			while($row = mysql_fetch_array($query))
			{
				$name = $row['condiName'];  
                
                // Output table entries
                Print "<tr>";
                    Print '<td>'.$name."</td>";               
                    Print '<td align="center"><a href="viewcondi.php?id='.$row['condiID'].'"><img src="images/viewButton.png" height="17" width="17"/></a></td>';                
                    Print '<td align="center"><a href="editcondi.php?id='.$row['condiID'].'"><img src="images/editButton.png" height="14" width="14"/></a></td>';
                    Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['condiID'].')"><img src="images/deleteButton.png" height="14" width="14"/></a></td>';
                Print "</tr>";                   
            }
            ?>

		</table></br>
    
		<table class="table6" cellpadding="2" cellspacing="5">
            <tr><td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Done" class="basic_button"/></a></td>
                <td><a href="addcondi.php"><input type="button" value="Add Entry" class="basic_button"/></a></td></tr>
        </table>
</center></td></tr></table>            

		<script>
			function deleteFunction(id)
			{
				var r=confirm("Are you sure you want to delete this record?");
				if (r==true)
				{
					window.location.assign("deletecondi.php?id=" + id);
				}
			}
		</script>
    </div></body>
</html>
