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

/* Select existing journal entries for accountID */
$query = mysql_query("Select * from journal WHERE accountID='$accountID' ORDER BY journalDate ASC, journalTime ASC");
$exists = mysql_num_rows($query);

if($exists>0) {
    while ($row = mysql_fetch_assoc($query)) {
   
    }
}

?>

<html>
    <head>
        <title>Calendar</title>
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet"  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <script src="zabuto_calendar.js"></script>
        <link rel="stylesheet" type="text/css" href="calendarstyle.css">
        


    </head>
    
    <body>
        
        <div id="my-calendar"></div>

        <script type="application/javascript">
            $(document).ready(function () {
                $("#my-calendar").zabuto_calendar({
                    language: "en",
                    cell_border: true,
                    today: true,
                    
                     
                });
            });
            
        </script>
    
    </body>
    
</html>