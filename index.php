<?php

$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";

$c = oci_connect($username, $password, $database);
if (!$c) {
    $m = oci_error();
    trigger_error('Could not connect to database: '. $m['message'], E_USER_ERROR);
}

if (isset($_POST['starting-year']))
{
    $start = $_POST['starting-year'];
}

if (isset($_POST['ending-year']))
{
    $end = $_POST['ending-year'];
}

$query = "SELECT SUM(TOTAL) AS TUPLE
FROM((SELECT COUNT(*) AS TOTAL FROM DOSPINA.COLLISION)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.TRAFFIC_CONTROL)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.ROAD_ALIGNMENT)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.ROAD_SURFACE)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.WEATHER_CONDITIONS)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.ROADWAY_CONFIGURATION)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.MONTH)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.WEEKDAY)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.HOUR)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.SEVERITY)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.COLLISION_CONFIGURATION)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.VEHICLE_TYPE)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.PERSON_POSITION)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.PERSON_SEVERITY)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.PERSON_SAFE)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.PERSON_USER)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.PERSON)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.VEHICLE))";

$s = oci_parse($c, $query);
if (!$s) {
    $m = oci_error($c);
    trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
}
$r = oci_execute($s);
if (!$r) {
    $m = oci_error($s);
    trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
}

$row = oci_fetch_array($s, OCI_BOTH);
$total = $row['TUPLE'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Traffic - Login</title>
</head>

<body class="homepage">
    <div class="homepage-grid">

        <div class="flag">
                <img src="flag.png" alt="">        </div>
           
        <div class="homepage-header">
            <h1>Canadian Car Accident Trends (1999-2014)</h1>
        </div>    


        <div class="comp">
            <button class="dropbtn" onclick="goToComp()">Complex Queries</button>
        </div>

        <div class="light">
            <img src="traffic light 2.png" alt="">
        </div>

        <div class="profile">
            <div class="dropdown">

                <button onclick="myFunction()" class="dropbtn">Settings</button>
                <div id="myDropdown" class="dropdown-content">
                    <a href="login.html">Log Out</a>
                </div>
            </div>
        </div>

        <div class="category-card people" onclick="goToPeople()">
            <h2>People</h2>
        </div>

        <div class="category-card vehicles" onclick="goToVehicles()">
            <h2>Vehicles</h2>
        </div>
        <div class="category-card safety" onclick="goToSafety()">
            <h2>Safety</h2>
        </div>
        <div class="category-card road" onclick="goToRoad()">
            <h2>Road</h2>
        </div>
        <div class="category-card severity" onclick="goToSeverity()">
            <h2>Severity</h2>
        </div>

        <div class="category-card weather" onclick="goToWeather()">
            <h2>Weather</h2>
        </div>

        <div class="category-card time" onclick="goToTime()">
            <h2>Time</h2>
        </div>

        <div class="category-card count-tuples" onclick="showTupleCount()">
            <h2><?=$total?></h2>
        </div>


    </div>
</body>

<script>


    /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function goToPeople() {
        window.location.href = "people.html";
    }

    function goToVehicles() {
        window.location.href = "vehicles.html";
    }

    function goToSafety() {
        window.location.href = "safety.html";
    }

    function goToRoad() {
        window.location.href = "road.html";
    }

    function goToSeverity() {
        window.location.href = "severity.html";
    }
    function goToWeather() {
        window.location.href = "weather.html";
    }

    function goToTime() {
        window.location.href = "time.html";
    }

    function goToComp() {
        window.location.href = "complicated-queries.html";
    }
    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }

    function showTupleCount(){
      //  window.location.href = "index.php"
    }
</script>

</html>