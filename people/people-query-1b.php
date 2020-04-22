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
if (isset($_POST['weather-cond']))
{
    $weather = $_POST['weather-cond'];
}
if (isset($_POST['road-surface']))
{
    $road = $_POST['road-surface'];
}
$query = "SELECT YEAR, ROUND(AVG(A.AGE),2) as AVG_AGE
FROM (SELECT p.age, p.position, p.medical_treatment, c.weather_id, c.roadsurface_id, c.year
FROM DOSPINA.PERSON P, DOSPINA.COLLISION C
WHERE P.CID = C.COLLISION_ID AND AGE <> -1 AND p.position = 11
AND p.medical_treatment BETWEEN 2 AND 3
AND c.weather_id = '$weather'
AND c.roadsurface_id = '$road') A
WHERE YEAR BETWEEN '$start' AND '$end'
GROUP BY A.YEAR
ORDER BY YEAR";

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
  $chart_data .= "{ year:'".$row["YEAR"]."', aver:".$row["AVG_AGE"]."}, ";
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
        <title>People Trends</title>
    </head>
</head>

<body class="trends-page">

    <div class="trends-page-grid">

        <div class="back" onclick="goHome()">
            <p>Back to Home</p>
        </div>

        <div class="trends-page-header">
            <h1>People Trends</h1>
        </div>

        <button onclick="done()" class="back-to-cat">People Queries</button>


        <div class="query-title">
            <h1>Find the average age of car accident driver (resulting in fatality and/or serious injury) in an adverse
                weather
                condition at certain road surface for a span of years</h1>
        </div>


        <div class="nested-form">

            <form id="query-form" method="post" action="" class="form-left-right">


                <div class="select-left">

                    <label for="weather-cond" class="selection-label">Weather Condition:</label>
                    <select name="weather-cond" id="weather-cond" class="mySelect">
                        <option value="1">Clear and Sunny</option>
                        <option value="2">Overcast</option>
                        <option value="3">Raining</option>
                        <option value="4">Snowing</option>
                        <option value="5">Freezing rain, sleet, hail</option>
                        <option value="6">Visibility Limitation</option>
                        <option value="7">Strong wind</option>
                    </select>

                    <label for="road-surface" class="selection-label">Road Surface:</label>
                    <select name="road-surface" id="road-surface" class="mySelect">
                        <option value="1">Dry, normal</option>
                        <option value="2">Wet</option>
                        <option value="3">Snow (fresh, loose snow)</option>
                        <option value="4">Slush, wet snow</option>
                        <option value="5">Icy, Includes packed snow</option>
                        <option value="6">Sand/gravel/dirt</option>
                        <option value="7">Muddy</option>
                        <option value="8">Oil</option>
                        <option value="9">Flooded</option>
                    </select>


                </div>


                <div class="select-right">


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
                        onclick="submitForm('people-query-1b.php')">
                    <input type="submit" class="enter-button" value="Line Chart"
                        onclick="submitForm('people-query-1l.php')">

                </div>


            </form>
        </div>

        <div class="y-axis">
            <h2>Average Age</h2>
        </div>
        <div class="display-full">
            <h1>Average Age of drivers included in fatal or serious collisions between <?=$start?> and <?=$end?>.</h1>
            <div id="chart"></div>
            <h2>Year</h2>
            <div id="legend"></div>
        </div>

    </div>

    </div>


</body>

<script>
function goHome() {
    window.location.href = "../index.html";
}

function done() {

    window.location.href = "../people.html";

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
    ykeys: ['aver'],
    labels: ['Average Age'],
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