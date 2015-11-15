<html>

<head>
    <title>Calendar</title>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <script src="zabuto_calendar.js"></script>
    <link rel="stylesheet" type="text/css" href="calendarstyle.css">

    <div id="my-calendar"></div>


</head>

<body>



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


        

    for($i=0; $i<count($personIDArray); $i++) {
        $personID = $personIDArray[$i];
        $query = mysql_query("Select * from events WHERE personID='$personID'");
    
        while($row = mysql_fetch_array($query)) {
            $date = $row['eventDate'];  
        
    
            echo '<script language="javascript">
            var js_var = "<?php echo $date;?>";
            
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