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

$query = "SELECT YEAR, NI, I
FROM
(SELECT COUNT(*) AS NI , YEAR
FROM DOSPINA.COLLISION 
WHERE ROADCONFIG_ID = 1
GROUP BY YEAR
ORDER BY YEAR)
NATURAL JOIN
(SELECT A.I + B.I AS I, A.YEAR 
FROM
(SELECT COUNT(*) AS I , YEAR
FROM DOSPINA.COLLISION 
WHERE ROADCONFIG_ID = 2
GROUP BY YEAR
ORDER BY YEAR) A,
(SELECT COUNT(*) AS I , YEAR
FROM DOSPINA.COLLISION 
WHERE ROADCONFIG_ID = 3
GROUP BY YEAR
ORDER BY YEAR) B
WHERE A.YEAR = B.YEAR)
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
  $chart_data .= "{ year:'".$row["YEAR"]."', ni:".$row["NI"].", i:".$row["I"]."}, ";
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
        <title>Road Trends</title>
    </head>
</head>

<body class="trends-page">

    <div class="trends-page-grid">

        <div class="back" onclick="goHome()">
            <p>Back to Home</p>
        </div>

        <div class="trends-page-header">
            <h1>Road Trends</h1>
        </div>

        <button onclick="done()" class="back-to-cat">Road Queries</button>


        <div class="query-title">
            <h1>Compare the number of accidents occurring at an intersection vs nonintersection</h1>
        </div>

        <div class="selector-box">

            <form method="POST" action="road-query-2.php">

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

                <br>
                <input type="submit" class="enter-button">

            </form>

        </div>

        <div class="display-graph">
            <h1>Accidents occuring at intersections and non-intersections between <?=$start?> and <?=$end?>.</h1>
            <div id="chart"></div>
        </div>
    </div>
</body>

<script>
    function goHome() {
        window.location.href = "../index.html";
    }

    function done() {

        window.location.href = "../road.html";

    }
</script>
<script>
Morris.Line({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'year',
 ykeys:['ni', 'i'],
 labels:['Non-Intersection', 'Intersection'],
 hideHover:'auto',
 stacked:false
});
</script>
</html>