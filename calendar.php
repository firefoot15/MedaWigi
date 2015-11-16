<html>

<head>
    <title>Cal Temp</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js">
    </script>
    <script src="calendarjavascript.js"></script>
    <link rel="stylesheet" type="text/css" href="calendarstyle.css">

    <div id="my-calendar"></div>
    <div id="list-container"></div>
    <div id="modal-container"></div>
</head>

<body>
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
        

        $(document).ready(function () {
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
                        url: "show_data.php",
                        modal: true
                    }
                },
                legend: [
                    {
                        label: "Rendez-vous",
                        type: "appointment"
                    },
                    {
                        label: "Journal Event",
                        type: "journal"
                    },
                    {
                        label: "Evenement B",
                        type: "eventtype3"
                    },
                    {
                        label: "<span class='fa fa-bell-o'></span> Rappel",
                        type: "reminder"
                    }
    ]
            });

        });
        
        
    </script>
    
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

    // Create journey events for each person and populate calendar
    for($i=0; $i<count($personIDArray); $i++) {
        $personID = $personIDArray[$i];
        $query = mysql_query("Select * from events WHERE personID='$personID'");
    
        while($row = mysql_fetch_array($query)) {
            $id = $row['eventID'];
            $date = $row['eventDate'];  
            $time = $row['eventTime'];
            $subject = $row['eventSubject'];
            $content = $row['eventContent'];
            $type = "journal";
//            echo $id . " ";
              echo $date . "<br>";
//            echo $subject . " " . "<br>";
            
            echo "<script> createEventsForArray('$id', '$date', '$subject', '$type', '$time', '$content'); 
            </script>";   
   
        }
            
    }
 
        ?>

</body>

</html>