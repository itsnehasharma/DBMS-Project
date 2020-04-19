<?php 

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
WHERE YEAR = 2000) X,
(SELECT *
FROM (SELECT a.DESCRIPTION AS DESC_B, COUNT(A.MEDICAL_TREATMENT) AS B_med, a.year
FROM (SELECT P.MEDICAL_TREATMENT, C.ROADCONFIG_ID, C.YEAR, RC.DESCRIPTION
FROM DOSPINA.collision C, DOSPINA.person P, DOSPINA.roadway_configuration RC
WHERE C.COLLISION_ID = p.cid AND P.MEDICAL_TREATMENT = 3 AND C.ROADCONFIG_ID <> -1 AND C.ROADCONFIG_ID = RC.ROADCONFIG_ID) A
GROUP BY a.DESCRIPTION, a.year
ORDER BY a.DESCRIPTION) B
WHERE YEAR = 2010) Y
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
   <div id="chart1"></div>
   <div id="chart2"></div>
  </div>
</center>
 </body>
</html>

<script>
Morris.Donut({
 element : 'chart1',
 data:[<?php echo $chart_data1; ?>]
});
</script>
<script>
Morris.Donut({
 element : 'chart2',
 data:[<?php echo $chart_data2; ?>]
});
</script>