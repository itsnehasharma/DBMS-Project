<?php 

$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$query = "SELECT YEAR, WEEKDAY, WEEKEND, ROUND(WEEKDAY/4,0) AS AVG_WEEK, ROUND(WEEKEND/3,0) AS AVG_WEEK_END
FROM
(SELECT A.EVENING_WEEKEND + B.NIGHT_WEEKEND + C.NIGHT_WEEKEND AS WEEKEND, A.YEAR
FROM 
(SELECT COUNT(*) AS EVENING_WEEKEND, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 5 AND 7 AND c.hour BETWEEN 20 AND 23
GROUP BY YEAR
ORDER BY YEAR) A,
(SELECT COUNT(*) AS NIGHT_WEEKEND, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 5 AND 7 AND c.hour BETWEEN 20 AND 23
GROUP BY YEAR
ORDER BY YEAR) B,
(SELECT COUNT(*) AS NIGHT_WEEKEND, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 5 AND 7 AND c.hour BETWEEN 0 AND 5
GROUP BY YEAR
ORDER BY YEAR) C
WHERE A.YEAR = B.YEAR AND A.YEAR = C.YEAR)
NATURAL JOIN
(SELECT A.EVENING_WEEKDAY + B.NIGHT_WEEKDAY + C.NIGHT_WEEKDAY AS WEEKDAY, A.YEAR
FROM 
(SELECT COUNT(*) AS EVENING_WEEKDAY, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 1 AND 4 AND c.hour BETWEEN 20 AND 23
GROUP BY YEAR
ORDER BY YEAR) A,
(SELECT COUNT(*) AS NIGHT_WEEKDAY, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 1 AND 4 AND c.hour BETWEEN 20 AND 23
GROUP BY YEAR
ORDER BY YEAR) B,
(SELECT COUNT(*) AS NIGHT_WEEKDAY, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 1 AND 4 AND c.hour BETWEEN 0 AND 5
GROUP BY YEAR
ORDER BY YEAR) C
WHERE A.YEAR = B.YEAR AND A.YEAR = C.YEAR)
WHERE YEAR BETWEEN 2000 AND 2005";

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
  $chart_data .= "{ year:'".$row["YEAR"]."', weekday:".$row["WEEKDAY"].", weekend:".$row["WEEKEND"].", avg_week:".$row["AVG_WEEK"].", avg_week_end:".$row["AVG_WEEK_END"]."}, ";
}
//To remove last comma from $chart_data
$chart_data = substr($chart_data, 0, -2);

?>


<!DOCTYPE html>
<html>
 <head>
  <title>Webslesson Tutorial | How to use Morris.js chart with PHP & Mysql</title>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  
 </head>
 <body>
  <center>
  <br /><br />
  <div class="container" style="width:900px;">
   <!--<h2 align="center">Morris.js chart with PHP & Mysql</h2>-->
   <h1 align="center">Collision Data Through the years</h3>   
   <br /><br />
   <div id="chart"></div>
  </div>
</center>
 </body>
</html>

<script>
Morris.Line({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'year',
 ykeys:['weekday', 'weekend', 'avg_week', 'avg_week_end'],
 labels:['Weekday', 'Weekend', 'Average on Weekdays', 'Average on Weekends'],
 hideHover:'auto',
 stacked:false
});
</script>