<?php
include 'connect.php';
?>

<html>
    <head>
        <title>Calendar</title>
    </head>
    <div id="calendar"></div>
    <body>
        
        <link rel="stylesheet" href="css/jquery.e-calendar.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/jquery.e-calendar.js"></script>

        <?php
        $(document).ready(function() {
        $('#calendar').eCalendar({
        weekDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
        'September', 'October', 'November', 'December'],
        textArrows: {previous:'<', next:'>'},
        eventTitle: 'Events',
        url: '',
        events: [
        {title: 'Event 1', description: 'Description 1', <a href="http://www.jqueryscript.net/time-clock/">date</a>time: new Date(2014, 7, 15, 17)},
        {title: 'Event 2', description: 'Description 2', datetime: new Date(2014, 7, 14, 16)},
        {title: 'Event 3', description: 'jQueryScript.Net', datetime: new Date(2014, 7, 10, 16)}
        ]});
        });
        ?>
        
        
    </body>
</html>