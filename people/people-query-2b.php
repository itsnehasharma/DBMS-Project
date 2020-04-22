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

$query = "SELECT year, A.BABIES, b.toddlers, c.kids, d.teenagers, e.young_adults, f.adults, g.senior_citizens
FROM (SELECT COUNT(ROWNUM) AS BABIES, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 0 AND 1 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) A NATURAL JOIN
(SELECT COUNT(ROWNUM) AS TODDLERS, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 2 AND 3 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) B NATURAL JOIN
(SELECT COUNT(ROWNUM) AS KIDS, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 4 AND 12 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) C NATURAL JOIN
(SELECT COUNT(ROWNUM) AS TEENAGERS, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 13 AND 19 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) D NATURAL JOIN
(SELECT COUNT(ROWNUM) AS YOUNG_ADULTS, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 20 AND 30 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) E NATURAL JOIN
(SELECT COUNT(ROWNUM) AS ADULTS, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 31 AND 60 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) F NATURAL JOIN
(SELECT COUNT(ROWNUM) AS SENIOR_CITIZENS, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age >=61 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) G
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
  $chart_data .= "{ year:'".$row["YEAR"]."', babies:".$row["BABIES"].", toddlers:".$row["TODDLERS"].", kids:".$row["KIDS"].", teenagers:".$row["TEENAGERS"].", young_adults:".$row["YOUNG_ADULTS"].", adults:".$row["ADULTS"].", senior_citizens:".$row["SENIOR_CITIZENS"]."}, ";
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
            <h1>Show the number of injuries in different age groups over a certain period of time</h1>
        </div>

        <div class="nested-form">


            <form id="query-form" method="POST" action="" class="form-left-right">

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
                        onclick="submitForm('people-query-2b.php')">
                    <input type="submit" class="enter-button" value="Line Chart"
                        onclick="submitForm('people-query-2l.php')">


                </div>

            </form>

        </div>

        <div class="y-axis">
            <h2>Number of Injuries</h2>
        </div>

        <div class="display-full">
            <h1>Number of injuries in different age groups between <?=$start?> and <?=$end?>.</h1>
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
    ykeys: ['babies', 'toddlers', 'kids', 'teenagers', 'young_adults', 'adults', 'senior_citizens'],
    labels: ['Babies', 'Toddlers', 'Kids', 'Teenagers', 'Young Adults', 'Adults', 'Senior Citizens'],
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