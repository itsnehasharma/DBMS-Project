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

$query = "SELECT *
  FROM (SELECT COUNT(ROWNUM) AS MALE, C.YEAR
  FROM DOSPINA.person P, DOSPINA.collision C
  WHERE P.CID = C.COLLISION_ID AND P.SEX <> '-1' AND p.position = 11 AND p.sex = 'M'
  GROUP BY c.year
  ORDER BY c.year) A NATURAL JOIN
  (SELECT COUNT(ROWNUM) AS FEMALE, C.YEAR
  FROM DOSPINA.person P, DOSPINA.collision C
  WHERE P.CID = C.COLLISION_ID AND P.SEX <> '-1' AND p.position = 11 AND p.sex = 'F'
  GROUP BY c.year
  ORDER BY c.year) B
  WHERE YEAR BETWEEN '$start' AND '$end'";

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
  $chart_data .= "{ year:'".$row["YEAR"]."', male:".$row["MALE"].", female:".$row["FEMALE"]."}, ";
}
//To remove last comma from $chart_data
$chart_data = substr($chart_data, 0, -2);

?>

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
            <h1>Show a trend of the number of male and female drivers involved in collisions occurring over a period of
                years</h1>
        </div>


        <div class="nested-form">

            <form method="POST" id="query-form" class="form-left-right">


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
                        onclick="submitForm('people-query-3b.php')">
                    <input type="submit" class="enter-button" value="Line Chart"
                        onclick="submitForm('people-query-3l.php')">

                </div>

            </form>

        </div>


        <div class="y-axis">
            <h2>Number of Collisions</h2>
        </div>
        <div class="display-full">
            <h1>Male-Female Collision Comparision between years <?=$start?> and <?=$end?>.</h1>
            <div id="chart"></div>
            <h2>Year</h2>
            <div id="legend" class="bars-legend"></div>
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
    ykeys: ['male', 'female'],
    labels: ['Male', 'Female'],
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