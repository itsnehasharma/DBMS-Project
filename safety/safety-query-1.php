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

$query = "SELECT * FROM(
SELECT YEAR, WITHOUT_SEATBELT , WITH_SEATBELT
FROM((
SELECT COUNT(*) AS WITHOUT_SEATBELT, C.Year
FROM dospina.COLLISION C, dospina.PERSON P
WHERE C.Collision_ID = P.cID AND P.Safety_Device_Used = 1 AND (P.medical_treatment = 3 OR P.medical_treatment = 2)
GROUP BY C.year
ORDER BY Year ASC
) 
NATURAL JOIN
(SELECT COUNT(*) AS WITH_SEATBELT, C.Year
FROM dospina.COLLISION C, dospina.PERSON P
WHERE C.Collision_ID = P.cID AND P.Safety_Device_Used = 2 AND (P.medical_treatment = 3 OR P.medical_treatment = 2)
GROUP BY C.year
ORDER BY Year ASC
))
)WHERE YEAR BETWEEN '$start' AND '$end'
";

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
  $chart_data .= "{ year:'".$row["YEAR"]."', without_seatbelt:".$row["WITHOUT_SEATBELT"].", with_seatbelt:".$row["WITH_SEATBELT"]."}, ";
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
        <title>Safety Trends</title>
    </head>
</head>

<body class="trends-page">

    <div class="trends-page-grid">

        <div class="back" onclick="goHome()">
            <p>Back to Home</p>
        </div>

        <div class="trends-page-header">
            <h1>Safety Trends</h1>
        </div>

        <button onclick="done()" class="back-to-cat">Safety Queries</button>


        <div class="query-title">
            <h1>Find number of fatalities and injuries from people who did and did not wear seatbelts for a range of years</h1>
        </div>

        <div class="nested-form">

<form class="form-left-right" method="post" action="safety-query-1.php" id="query-form">

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

        <input type="submit" class="enter-button" value="Bar Chart" onclick="submitForm('safety-query-1b.php')">
        <input type="submit" class="enter-button" value="Line Chart" onclick="submitForm('safety-query-1l.php')">
    </div>


</form>
</div>
    
<div class="y-axis"><h2>y-axis</h2></div>
         <div class="display-graph">
            <h1>Fatalities and injuries for people with and without seatbelts between <?=$start?> and <?=$end?>.</h1>
            <div id="chart"></div>
            <h2>x axis</h2>
        </div>

    </div>

    </div>


</body>

<script>
    function goHome() {
        window.location.href = "../index.html";
    }

    function done() {

        window.location.href = "../safety.html";

    }
</script>
<script>
Morris.Line({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'year',
 ykeys:['without_seatbelt', 'with_seatbelt'],
 labels:['Without Seatbelt', 'With Seatbelt'],
 hideHover:'auto',
 stacked:false
});
</script>
</html>