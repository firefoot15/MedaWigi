<html>

<head>
    <title>Calendar</title>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <script src="zabuto_calendar.js"></script>
    <link rel="stylesheet" type="text/css" href="calendarstyle.css">

    <div id="my-calendar"></div>

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
<<<<<<< HEAD
    <script>
        
        var events_array = [];
        function createEventsForArray(id,date,title,type,time,description) 
        {

            
            events_array.push({
            "id": id,
            "date": date,
            "title": title,
            "type": type,
            "disabled": true,
            "reminder": "",
            "time": time,
            "description": description
        });
         
            return events_array;
        }
        
=======
>>>>>>> efc194631b1b8edaded9f2eec48f2e908d49e079



    <?php
    include 'connect.php';
    session_start();
    /* Verify Username */
    if($_SESSION['user']){}
    else {
        header("location:index.php"); }
    $user = $_SESSION['user'];
    /* Selct accountID of given username */
    $query = mysql_query("Select accountID from accounts WHERE username = '$user' limit 1");
    $accountID = mysql_result($query,0);
    // Using accountID, populate array with persons 
    $query = mysql_query("Select * from mappings WHERE accountID = '$accountID'");
    $row = mysql_fetch_array($query);
    $personIDArray = array();
    for($i=0; $i<10; $i++) {
        $colName = $i.'_personID';
        $personID = abs($row[$colName]);
        if($personID != 0) {
            array_push($personIDArray, $personID);
        }
    }
<<<<<<< HEAD
    

    // Create journey events for each person and populate calendar
    for($ind=0; $ind<count($personIDArray); $ind++) {
        
        $personID = $personIDArray[$ind];
        $query = mysql_query("Select * from events WHERE personID='$personID'");
        
     
        while($row = mysql_fetch_assoc($query)) {
            
            $id = $row['eventID'];
            $date = $row['eventDate'];  
            $time = $row['eventTime'];
            $subject = $row['eventSubject'];
            $content = $row['eventContent'];
            $type = "journal";
=======
        
    for($i=0; $i<count($personIDArray); $i++) {
        $personID = $personIDArray[$i];
        $query = mysql_query("Select * from events WHERE personID='$personID'");
    
        while($row = mysql_fetch_array($query)) {
            $date = $row['eventDate'];  
        
    
            echo '<script language="javascript">
            var js_var = "<?php echo $date;?>";
>>>>>>> efc194631b1b8edaded9f2eec48f2e908d49e079
            
            var eventData = {
            date: js_var,
            badge: true,
            title: "Event",
            body: "",
            footer: "",
            classname: ""
            };
            </script>';
        
            echo '<script>alert(eventData); </script>';
        }
    }
<<<<<<< HEAD
=======
    
>>>>>>> efc194631b1b8edaded9f2eec48f2e908d49e079
        ?>
    
    
    
    <script>
        $(document).ready(function () {
            $("#my-calendar").zabuto_calendar({
                language: "en",
                cell_border: true,
                today: true,
                data: eventData
            });
    
        });
        
    </script>





</body>

</html>
