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
            <h1>Show a trend of the number of male and female drivers involved in collisions occurring over a period of years</h1>
        </div>


        <!-- does this need to be in a form wrapper? -->

        <div class="selector-box">

            <form method="POST" action="" id="query-forn">

                <!--<label for="starting-month" class="selection-label">Starting Month: </label>
                <select name="starting-month" id="starting-month" class="mySelect">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>-->

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

<<<<<<< HEAD
=======
                <!--<label for="ending-month" class="selection-label">Ending Month: </label>
                <select name="ending-month" id="ending-month" class="mySelect">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>-->

>>>>>>> 7bb2a40f798ded1023c2325b33e180351bfbb745
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
                <input type="submit" class="enter-button" value="Bar Chart" onclick="submitForm('people-query-3b.php')">
                <input type="submit" class="enter-button" value="Line Chart" onclick="submitForm('people-query-3l.php')">
            </form>

        </div>


        <div class="display-graph">
            <h1>Male-Female Collision Comparision between years <?=$start?> and <?=$end?>.</h1>
            <div id="chart"></div>
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
<<<<<<< HEAD
    }

     function submitForm(action){
=======

    }

    function submitForm(action){
>>>>>>> 7bb2a40f798ded1023c2325b33e180351bfbb745
        document.getElementById('query-form').action = action;
        document.getElementById('query-form').submit();
    }
</script>
<script>
Morris.Line({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'year',
 ykeys:['male', 'female'],
 labels:['Male', 'Female'],
 hideHover:'auto',
 stacked:false
});
</script>

</html>