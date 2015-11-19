<!--    MEDICATIONS PAGE
        Displays a list of all medications associated with personID.
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

        // Access accountID associated with person
        $query = mysql_query("Select accountID from accounts WHERE username = '$user' limit 1");
        $accountID = mysql_result($query, 0);     

        // Access personID associated with account to be used in h1
        $query = mysql_query("Select 0_personID from mappings WHERE accountID = '$accountID' limit 1");
        $pid = mysql_result($query, 0);

        // Use personID to access nickname in persons table to be used in h1
		$query = mysql_query("Select nickname from persons WHERE personID = '$id' limit 1");
		$nickname = mysql_result($query, 0); 
        ?>

            <!-- View medications form-->
<html>
	<head>
		<title>Medications</title>
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
		<h2>MEDICATIONS</h2>
        <div class="wrapper"> 
        <table class="page_table"><tr><td></td><td><center>
        <h1><?php if($pid == $id)echo 'My'; else echo htmlspecialchars($nickname)."'s";?> Medications</h1>    
        <table class="table3">
			<tr>
				<th align="left">Name</th>
				<th align="left">Status</th>                
                <th align="left">Rx #</th>
				<th>Directions</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php
            
			// Sort by status
			$query = mysql_query("Select * from medications WHERE personID = '$id' ORDER BY medicStatus DESC");
			while($row = mysql_fetch_array($query))
			{
				$name = $row['medicName']; 
				$status = $row['medicStatus'];                
                $rx = $row['medicRxNo'];                
                
                // Output table entries
                Print "<tr>";
                    Print '<td>'.$name."</td>";
                    Print '<td>'.$status."</td>";
                    Print '<td>'.$rx."</td>";                 
                    Print '<td align="center"><a href="viewmedic.php?id='.$row['medicID'].'"><img src="images/viewButton.png" height="17" width="17"/></a></td>';                
                    Print '<td align="center"><a href="editmedic.php?id='.$row['medicID'].'"><img src="images/editButton.png" height="14" width="14"/></a></td>';
                    Print '<td align="center"><a href="#" onclick="deleteFunction('.$row['medicID'].')"><img src="images/deleteButton.png" height="14" width="14"/></a></td>';
                Print "</tr>";                   
            }
            ?>

		</table></br>
    
		<table class="table6" cellpadding="2" cellspacing="5">
            <tr><td><a href="personhome.php?id=<?php echo htmlspecialchars($id); ?>"><input type="button" value="Done" class="basic_button"/></a></td>
                <td><a href="addmedic.php"><input type="button" value="Add Entry" class="basic_button"/></a></td></tr>
        </table>
</center></td></tr></table>            

		<script>
			function deleteFunction(id)
			{
				var r=confirm("Are you sure you want to delete this record?");
				if (r==true)
				{
					window.location.assign("deletemedic.php?id=" + id);
				}
			}
		</script>
    </div></body>
</html>
