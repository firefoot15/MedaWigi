<html>

<head>

    <?php 
    include 'connect.php';
    session_start();
    ?>
    
          <link href='style.css' rel='stylesheet' type='text/css'>    
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <script src="medawigi.js"></script>
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


<title>Calendar</title>
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
        <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
        <link href="/Content/theme/base/jquery.ui.all.css" rel="stylesheet" />



        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <script src="calendarjavascript.js"></script>
        <link rel="stylesheet" type="text/css" href="calendarstyle.css">

        <div id="my-calendar"></div>
        <div id="list-container"></div>


<body>
    <script>
        var events_array = [];
        function createEventsForArray(id, date, title, type, time, description,person) {
            events_array.push({
                "id": id,
                "date": date,
                "title": title,
                "type": type,
                "disabled": false,
                "reminder": "",
                "time": time,
                "description": description,
                "person": person
            });
            return events_array;
        }
    </script>

    <?php
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
    // Create journey events for each person and populate calendar
    for($ind=0; $ind<count($personIDArray); $ind++) {
        
        $personID = $personIDArray[$ind];
        $query = mysql_query("Select * from events WHERE personID='$personID'");  
        $query2 = mysql_query("Select nickname from persons WHERE personID='$personID'");
        $nickname = mysql_result($query2, 0);
        
     
        while($row = mysql_fetch_assoc($query)) {
            
            $id = $row['eventID'];
            $date = $row['eventDate'];  
            $time = $row['eventTime'];
            $subject = $row['eventSubject'];
            $content = $row['eventContent'];
            $type = "journal";
    
                
            echo "<script> createEventsForArray('$id','$date','$subject','$type','$time','$content', '$nickname');</script>";
                 
        }
    }  
?>
        <script>
            $("#my-calendar").zabuto_calendar({
                language: "en",
                callbacks: {
                    on_cell_double_clicked: function () {
                        return cellDoubleClicked(this);
                    },
                    on_cell_clicked: function () {
                        return cellClicked(this);
                    },
                    on_nav_clicked: function () {
                        return navClicked(this);
                    },
                    on_event_clicked: function () {
                        return eventClicked(this);
                    }
                },
                events: {
                    local: events_array,
                    ajax: {
                        url: "show_data.php" // load ajax json events here...
                    }
                },
            });
        </script>
</body>

</html>
