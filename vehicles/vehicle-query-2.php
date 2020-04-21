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

$query = "SELECT YEAR, ROUND(TYPE_1/TOTAL*100,2) AS Type_1, ROUND(TYPE_5/TOTAL*100,2) AS Type_5, ROUND(TYPE_6/TOTAL*100,2) AS Type_6, 
ROUND(TYPE_7/TOTAL*100,2) AS Type_7, ROUND(TYPE_8/TOTAL*100,2) AS Type_8, ROUND(TYPE_9/TOTAL*100,2) AS Type_9, 
ROUND(TYPE_10/TOTAL*100,2) AS Type_10, ROUND(TYPE_11/TOTAL*100,2) AS Type_11, ROUND(TYPE_14/TOTAL*100,2) AS Type_14, 
ROUND(TYPE_16/TOTAL*100,2) AS Type_16, ROUND(TYPE_17/TOTAL*100,2) AS Type_17, ROUND(TYPE_18/TOTAL*100,2) AS Type_18, 
ROUND(TYPE_19/TOTAL*100,2) AS Type_19, ROUND(TYPE_20/TOTAL*100,2) AS Type_20, ROUND(TYPE_21/TOTAL*100,2) AS Type_21, 
ROUND(TYPE_22/TOTAL*100,2) AS Type_22, ROUND(TYPE_23/TOTAL*100,2) AS Type_23
FROM (SELECT TYPE_1, type_5, type_6, type_7, type_8, type_9, type_10, type_11, type_14, type_16, type_17, type_18, type_19, type_20, type_21, type_22, type_23, 
TYPE_1 + TYPE_5 + TYPE_6 + TYPE_7 + TYPE_8 + TYPE_9 + TYPE_10 + TYPE_11 + TYPE_14 + TYPE_16 + TYPE_17 + TYPE_18 + TYPE_19 + TYPE_20 + TYPE_21 + TYPE_22 + TYPE_23 AS TOTAL, YEAR
FROM (SELECT COUNT(A.VEHICLE_ID) AS TYPE_1, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 1
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_5, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 5
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_6, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 6
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_7, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 7
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_8, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 8
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_9, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 9
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_10, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 10
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_11, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 11
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_14, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 14
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_16, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 16
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_17, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 17
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_18, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 18
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_19, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 19
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_20, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 20
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_21, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 21
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_22, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 22
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_23, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 23
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)
WHERE YEAR BETWEEN '$start' AND '$end')";

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
  $chart_data .= "{ year:'".$row["YEAR"]."', type_1:".$row["TYPE_1"].", type_5:".$row["TYPE_5"].", type_6:".$row["TYPE_6"].", type_7:".$row["TYPE_7"].", type_8:".$row["TYPE_8"].", type_9:".$row["TYPE_9"].", type_10:".$row["TYPE_10"].", type_11:".$row["TYPE_11"].", type_14:".$row["TYPE_14"].", type_16:".$row["TYPE_16"].", type_17:".$row["TYPE_17"].", type_18:".$row["TYPE_18"].", type_19:".$row["TYPE_19"].", type_20:".$row["TYPE_20"].", type_21:".$row["TYPE_21"].", type_22:".$row["TYPE_22"].", type_23:".$row["TYPE_23"]."}, ";
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
        <title>Vehicle Trends</title>
    </head>
</head>

<body class="trends-page">

    <div class="trends-page-grid">

        <div class="back" onclick="goHome()">
            <p>Back to Home</p>
        </div>

        <div class="trends-page-header">
            <h1>Vehicle Trends</h1>
        </div>

        <button onclick="done()" class="back-to-cat">Vehicle Queries</button>


        <div class="query-title">
            <h1>Display a chart showing the number of collisions for each vehicle type over a period of months
                or years
            </h1>
        </div>


        <div class="nested-form">

            <form method="post" action="vehicle-query-2.php" class="form-left-right">

                <div class="select-left">
                        <label for="starting-year" class="selection-label">Starting Year: </label>
                        <select name="starting-year" id="starting-year" class="mySelect">
                            <!--<option value="1999">1999</option>-->
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
                            <!--<option value="1999">1999</option>-->
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
        </div>

        <div class="display-full">
            <h1>Ratio of collisions between various different types of vehicles between <?=$start?> and <?=$end?>.</h1>
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

        window.location.href = "../vehicles.html";

    }
</script>
<script>
Morris.Bar({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'year',
 ykeys:['type_1','type_5','type_6','type_7','type_8','type_9','type_10','type_11','type_14','type_16','type_17','type_18','type_19','type_20','type_21','type_22','type_23'],
 labels:['Light Duty Vehicle ','Panel/cargo van','Other trucks and vans','Unit trucks > 4536 kg','Road Tractor','School Bus','Smaller School Bus','Urban and Intercity Bus','Motorcycle and moped','Off road vehicles','Bicycle','Purpose-built motorhome','Farm Equipment','Construction equipment ','Fire engine','Snowmobile','Street car'],
 hideHover:'auto',
 stacked:false
});
</script>
</html>