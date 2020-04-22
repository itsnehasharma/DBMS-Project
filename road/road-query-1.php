<?php


if (isset($_POST['year-1']))
{
    $year1 = $_POST['year-1'];
}
if (isset($_POST['year-2']))
{
    $year2 = $_POST['year-2'];
}


$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$query = "SELECT *
FROM (SELECT *
FROM (SELECT a.DESCRIPTION AS DESC_A, COUNT(A.MEDICAL_TREATMENT) AS A_med, a.year
FROM (SELECT P.MEDICAL_TREATMENT, C.ROADCONFIG_ID, C.YEAR, RC.DESCRIPTION
FROM DOSPINA.collision C, DOSPINA.person P, DOSPINA.roadway_configuration RC
WHERE C.COLLISION_ID = p.cid AND P.MEDICAL_TREATMENT = 3 AND C.ROADCONFIG_ID <> -1 AND C.ROADCONFIG_ID = RC.ROADCONFIG_ID) A
GROUP BY a.DESCRIPTION, a.year
ORDER BY a.DESCRIPTION) B
WHERE YEAR = '$year1') X,
(SELECT *
FROM (SELECT a.DESCRIPTION AS DESC_B, COUNT(A.MEDICAL_TREATMENT) AS B_med, a.year
FROM (SELECT P.MEDICAL_TREATMENT, C.ROADCONFIG_ID, C.YEAR, RC.DESCRIPTION
FROM DOSPINA.collision C, DOSPINA.person P, DOSPINA.roadway_configuration RC
WHERE C.COLLISION_ID = p.cid AND P.MEDICAL_TREATMENT = 3 AND C.ROADCONFIG_ID <> -1 AND C.ROADCONFIG_ID = RC.ROADCONFIG_ID) A
GROUP BY a.DESCRIPTION, a.year
ORDER BY a.DESCRIPTION) B
WHERE YEAR = '$year2') Y
WHERE X.DESC_A = Y.DESC_B";

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

$chart_data1 = " ";
$chart_data2 = " ";
while($row = oci_fetch_array($s, OCI_BOTH)){
  //$data[] = $row;
  //'" < These quotes + Double quotes below on year represent X-Axis > "'
  $chart_data1 .= "{ label: '".$row["DESC_A"]."', value: ".$row["A_MED"]."}, ";
  $chart_data2 .= "{ label: '".$row["DESC_B"]."', value: ".$row["B_MED"]."}, ";

}
//To remove last comma from $chart_data
$chart_data1 = substr($chart_data1, 0, -2);
$chart_data2 = substr($chart_data2, 0, -2);
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
<style type="text/css">
.donut-legend>span {
    display: inline-block;
    margin-right: 25px;
    margin-bottom: 10px;
    font-size: 13px;
}

.donut-legend>span:last-child {
    margin-right: 0;
}

.donut-legend>span>i {
    display: inline-block;
    width: 15px;
    height: 15px;
    margin-right: 7px;
    margin-top: -3px;
    vertical-align: middle;
    border-radius: 1px;
}

#browsers_chart {
    max-height: 280px;
    margin-top: 20px;
    margin-bottom: 20px;
}
</style>

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
            <h1>Display two pie charts depicting the number of fatalities that occur at different road configurations in
                two
                different years (Interactive)</h1>
        </div>



        <div class="nested-form">


            <form method="post" action="road-query-1.php" class="form-left-right">


                <div class="select-left">

                    <label for="year-1" class="selection-label">Year 1:</label>
                    <select name="year-1" id="year-1" class="mySelect">
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

                    <label for="year-2" class="selection-label">Year 2:</label>
                    <select name="year-2" id="year-2" class="mySelect">
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

                    <input type="submit" class="enter-button">

                </div>

            </form>

            <div class="form-left-right">

                <div class="select-left">

                    <h1><?=$year1?></h1>
                    <div id="chart1"></div>

                </div>

                <div class="select-right">

                    <h1><?=$year2?></h1>
                    <div id="chart2"></div>
                    <!--<div id="legend1" class="donut-legend"></div>-->
                </div>

            </div>
            <div id="legend" class="donut-legend"></div>


            <br>

        </div>

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
var color_array = ['#F2594A', '#F28C4B', '#7E6F6A', '#319deb', '#9c6db2', '#d24a67', '#89a958', '#9722d6'];
var xyz = Morris.Donut({
    element: 'chart1',
    data: [ <?php echo $chart_data1; ?> ],
    colors: color_array
});
xyz.options.data.forEach(function(label, i) {
    var legendItem = $('<span></span>').text(label['label']).prepend(' <i>&nbsp;</i>');
    legendItem.find('i').css('backgroundColor', xyz.options.colors[i]);
    $('#legend').append(legendItem)
});
</script>

<script>
var color_array = ['#F2594A', '#F28C4B', '#7E6F6A', '#319deb', '#9c6db2', '#d24a67', '#89a958', '#9722d6'];
var abc = Morris.Donut({
    element: 'chart2',
    data: [ <?php echo $chart_data2; ?> ],
    colors: color_array
});
abc.options.data.forEach(function(label, i) {
    var legendItem = $('<span></span>').text(label['label']).prepend('<br><i>&nbsp;</i>');
    legendItem.find('i').css('backgroundColor', abc.options.colors[i]);
    $('#legend1').append(legendItem)
});
</script>

</html>