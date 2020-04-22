<?php

if (isset($_POST['year']))
{
    $year = $_POST['year'];
}

$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$query = "SELECT YEAR, ROUND(FATALITIES*100/(FATALITIES+NF),2) AS F, ROUND(NF*100/(FATALITIES+NF),2) AS NF
          FROM(SELECT COUNT(A.PID) AS FATALITIES, A.YEAR
          FROM (SELECT p.pid, C.YEAR
          FROM dospina.PERSON P, DOSPINA.collision C
          WHERE p.cid = C.COLLISION_ID AND P.MEDICAL_TREATMENT = 3) A
          GROUP BY A.YEAR
          ORDER BY A.YEAR) X
          NATURAL JOIN
          (SELECT COUNT(A.PID) AS NF, A.YEAR
          FROM (SELECT p.pid, C.YEAR
          FROM dospina.PERSON P, DOSPINA.collision C
          WHERE p.cid = C.COLLISION_ID AND P.MEDICAL_TREATMENT <> 3 AND P.MEDICAL_TREATMENT <> -1) A
          GROUP BY A.YEAR
          ORDER BY A.YEAR) Y
          WHERE YEAR = '$year'";

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
  $chart_data .= "{ year:'".$row["YEAR"]."', f:".$row["F"].", nf:".$row["NF"]."}, ";
}
//To remove last comma from $chart_data
$chart_data = substr($chart_data, 0, -2);


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="..\styles.css">
        <title>Severity Trends</title>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    </head>
</head>

<body class="trends-page">

    <div class="trends-page-grid">

        <div class="back" onclick="goHome()">
            <p>Back to Home</p>
        </div>

        <div class="trends-page-header">
            <h1>Severity Trends</h1>
        </div>

        <button onclick="done()" class="back-to-cat">Severity Queries</button>


        <div class="query-title">
            <h1>Calculate the ratio of fatalities to non-fatal injuries from accidents given a year</h1>
        </div>


        <div class="selector-box">

            <form method="post" action="severity-query-1.php" id="query-form">


                <label for="year" class="selection-label">Year: </label>
                <select name="year" id="year" class="mySelect">
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
                <br>
                <input type="submit" class="enter-button" value="Bar Chart"
                    onclick="submitForm('severity-query-1b.php')">
                <!-- <input type="submit" class="enter-button" value="Line Chart" onclick="submitForm('severity-query-1l.php')"> -->


            </form>
        </div>

        <div class="y-axis">
            <h2>Ratio of Fatalities to Non-Fatalities (%)</h2>
        </div>
        <div class="display-full">
            <h1>Ratio of Fatalities to Non-Fatalities in the year <?=$year?>.</h1>
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

    window.location.href = "../severity.html";

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
    ykeys: ['f', 'nf'],
    labels: ['Fatalities', 'Non-Fatalities'],
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