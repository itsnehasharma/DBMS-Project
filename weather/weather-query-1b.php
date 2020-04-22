<?php

if (isset($_POST['starting-year']))
{
    $start = $_POST['starting-year'];
}
if (isset($_POST['ending-year']))
{
    $end = $_POST['ending-year'];
}

$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$query = "SELECT YEAR, W_1, W_2, W_3, W_4, W_5, W_6, W_7
FROM (SELECT COUNT(A.COLLISION_ID) AS W_1, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 1
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_2, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 2
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_3, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 3
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_4, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 4
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_5, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 5
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_6, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 6
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_7, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 7
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR)
WHERE YEAR BETWEEN '$start' AND '$end'";

$c = oci_connect($username, $password, $database);
if (!$c) {
    $m = oci_error();
    trigger_error('Could not connect to database: '. $m['message'], E_USER_ERROR);
}
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

$chart_data = " ";
while($row = oci_fetch_array($s, OCI_BOTH)){
  //$data[] = $row;
  //'" < These quotes + Double quotes below on year represent X-Axis > "'
  $chart_data .= "{ year:'".$row["YEAR"]."', w_1:".$row["W_1"].", w_2:".$row["W_2"].", w_3:".$row["W_3"].", w_4:".$row["W_4"].", w_5:".$row["W_5"].", w_6:".$row["W_6"].", w_7:".$row["W_7"]."}, ";
}
//To remove last comma from $chart_data
$chart_data = substr($chart_data, 0, -2);


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="..\styles.css">
        <title>Vehicle Trends</title>
    </head>
</head>

<body class="trends-page">

    <div class="trends-page-grid">

        <div class="back" onclick="goHome()">
            <p>Back to Home</p>
        </div>

        <div class="trends-page-header">
            <h1>Weather Trends</h1>
        </div>

        <button onclick="done()" class="back-to-cat">Weather Queries</button>


        <div class="query-title">
            <h1>Show a trend of the number of accidents occurring per year over a variable time span of years with
                respect to the weather conditions </h1>
        </div>


        <div class="nested-form">

            <form method="post" action="weather-query-1.php" id="query-form" class="form-left-right">


                <div class="select-left">
                    <label for="starting-year" class="selection-label">Starting Year: </label>
                    <select name="starting-year" id="starting-year" class="mySelect">
                        <option value="1999">1999</option>
                        <option value="2000">2000</option>
                        <option value="2001">2001</option>
                        <option value="2002">2002</option>
                        <option value="2003">2003</option>
                        <option value="2004">2004</option>
                        <option value="2005">2005</option>
                        <option value="2006">2006</option>
                        <option value="2007">2007</option>
                        <option value="2008">2008</option>
                        <option value="2009">2009</option>
                        <option value="2010">2010</option>
                        <option value="2011">2011</option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                    </select>


                </div>


                <div class="select-right">

                    <label for="ending-year" class="selection-label">Ending Year:</label>
                    <select name="ending-year" id="ending-year" class="mySelect">
                        <option value="1999">1999</option>
                        <option value="2000">2000</option>
                        <option value="2001">2001</option>
                        <option value="2002">2002</option>
                        <option value="2003">2003</option>
                        <option value="2004">2004</option>
                        <option value="2005">2005</option>
                        <option value="2006">2006</option>
                        <option value="2007">2007</option>
                        <option value="2008">2008</option>
                        <option value="2009">2009</option>
                        <option value="2010">2010</option>
                        <option value="2011">2011</option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                    </select>

                </div>


                <div class="select-left">

                    <input type="submit" class="enter-button" value="Bar Chart"
                        onclick="submitForm('weather-query-1b.php')">
                </div>
            </form>
        </div>



        <div class="y-axis">
            <h2>Number of Collisions</h2>
        </div>
        <div class="display-full">
            <h1>Collisions for different weather conditions between years <?=$start?> and <?=$end?>.</h1>
            <div id="chart"></div>
            <h2>Year</h2>

        </div>
        <div id="legend" class="bars-legend display-full"></div>


    </div>

    </div>


</body>

<script>
function goHome() {
    window.location.href = "../index.html";
}

function done() {

    window.location.href = "../weather.html";

}

function submitForm(action) {
    document.getElementById('query-form').action = action;
    document.getElementById('query-form').submit();
}
</script>
<script>
var abc = Morris.Bar({
    element: 'chart',
    data: [ <?php echo $chart_data; ?> ],
    xkey: 'year',
    ykeys: ['w_1', 'w_2', 'w_3', 'w_4', 'w_5', 'w_6', 'w_7'],
    labels: ['Clear And Sunny', 'Overcast', 'Raining', 'Snowing', 'Freezing rain, sleet, hail',
        'Visibility Limitation', 'Strong Wind'
    ],
    hideHover: 'auto',
    stacked: false
});

abc.options.labels.forEach(function(label, i) {
    var legendItem = $('<span></span>').text(label).prepend(' <span>&nbsp;</span>');
    legendItem.find('span')
        .css('backgroundColor', abc.options.barColors[i])
        .css('width', '20px')
        .css('display', 'inline-block')
        .css('margin', '5px');
    $('#legend').append(legendItem)
});
</script>

</html>