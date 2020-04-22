<?php

if (isset($_POST['year']))
{
    $year = $_POST['year'];
}

$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$query = "SELECT MONTH, AM, AA, AE, AN
FROM
(SELECT A.MORNING AS AM, B.DESCRIPTION AS MONTH
FROM
(SELECT COUNT(*) AS MORNING, MONTH
FROM DOSPINA.collision C
WHERE c.hour BETWEEN 6 AND 11 AND YEAR = '$year' AND MONTH <> -1
GROUP BY MONTH
ORDER BY MONTH) A,
(SELECT DESCRIPTION, MONTH_ID
FROM DOSPINA.MONTH 
WHERE MONTH_ID <> -1) B
WHERE A.MONTH = B.MONTH_ID)
NATURAL JOIN
(SELECT A.AFTERNOON AS AA, B.DESCRIPTION AS MONTH
FROM
(SELECT COUNT(*) AS AFTERNOON, MONTH
FROM DOSPINA.collision C
WHERE c.hour BETWEEN 12 AND 16 AND YEAR = '$year' AND MONTH <> -1
GROUP BY MONTH
ORDER BY MONTH) A,
(SELECT DESCRIPTION, MONTH_ID
FROM DOSPINA.MONTH 
WHERE MONTH_ID <> -1) B
WHERE A.MONTH = B.MONTH_ID)
NATURAL JOIN
(SELECT A.EVENING AS AE, B.DESCRIPTION AS MONTH
FROM
(SELECT COUNT(*) AS EVENING, MONTH
FROM DOSPINA.collision C
WHERE c.hour BETWEEN 17 AND 19 AND YEAR = '$year' AND MONTH <> -1
GROUP BY MONTH
ORDER BY MONTH) A,
(SELECT DESCRIPTION, MONTH_ID
FROM DOSPINA.MONTH 
WHERE MONTH_ID <> -1) B
WHERE A.MONTH = B.MONTH_ID)
NATURAL JOIN
(SELECT N1+N2 AS AN, MONTH
FROM
(SELECT A.NIGHT AS N1, B.DESCRIPTION AS MONTH
FROM
(SELECT COUNT(*) AS NIGHT, MONTH
FROM DOSPINA.collision C
WHERE c.hour BETWEEN 20 AND 23 AND YEAR = '$year' AND MONTH <> -1
GROUP BY MONTH
ORDER BY MONTH) A,
(SELECT DESCRIPTION, MONTH_ID
FROM DOSPINA.MONTH 
WHERE MONTH_ID <> -1) B
WHERE A.MONTH = B.MONTH_ID) 
NATURAL JOIN
(SELECT A.NIGHT AS N2, B.DESCRIPTION AS MONTH
FROM
(SELECT COUNT(*) AS NIGHT, MONTH
FROM DOSPINA.collision C
WHERE c.hour BETWEEN 0 AND 5 AND YEAR = '$year' AND MONTH <> -1
GROUP BY MONTH
ORDER BY MONTH) A,
(SELECT DESCRIPTION, MONTH_ID
FROM DOSPINA.MONTH 
WHERE MONTH_ID <> -1) B
WHERE A.MONTH = B.MONTH_ID))";

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
  $chart_data .= "{ month:'".$row["MONTH"]."', am:".$row["AM"].", aa:".$row["AA"].", ae:".$row["AE"].", an:".$row["AN"]."}, ";
}
//To remove last comma from $chart_data
$chart_data = substr($chart_data, 0, -2);
echo $chart_data;
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
        <title>Time Trends</title>
    </head>
</head>

<body class="trends-page">

    <div class="trends-page-grid">

        <div class="back" onclick="goHome()">
            <p>Back to Home</p>
        </div>

        <div class="trends-page-header">
            <h1>Time Trends</h1>
        </div>

        <button onclick="done()" class="back-to-cat">Time Queries</button>


        <div class="query-title">
            <h1>Show a graph depicting the number of accidents over a period of 12 months of a particular year
                with respect to astronomical twilight</h1>
        </div>


        <div class="selector-box">

            <form method="post" action="time-query-1.php" id="query-form">


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
                <input type="submit" class="enter-button" value="Bar Chart" onclick="submitForm('time-query-1b.php')">

            </form>
        </div>


        <div class="y-axis">
            <h2>y-axis</h2>
        </div>

        <div class="display-full">
            <h1>Number of collisions for different astronomical twilights over the year <?=$year?>.</h1>
            <div id="chart"></div>
            <h2>x axis</h2>


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

    window.location.href = "../time.html";

}

function submitForm(action) {
    document.getElementById('query-form').action = action;
    document.getElementById('query-form').submit();
}
</script>

</html>

<script>
var abc = Morris.Line({
    element: 'chart',
    data: [ <?php echo $chart_data; ?> ],
    xkey: 'month',
    ykeys: ['am', 'aa', 'ae', 'an'],
    labels: ['Morning', 'Afternoon', 'Evening', 'Night'],
    hideHover: 'auto',
    stacked: false
});

abc.options.labels.forEach(function(label, i) {
    var legendItem = $('<span></span>').text(label).prepend(' <span>&nbsp;</span>');
    legendItem.find('span')
        .css('backgroundColor', abc.options.lineColors[i])
        .css('width', '20px')
        .css('display', 'inline-block')
        .css('margin', '5px');
    $('#legend').append(legendItem)
});
</script>