<?php 

$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$query = "SELECT YEAR, ROUND(FATALITIES*100/(FATALITIES+NF),2) AS F, ROUND(NF*100/(FATALITIES+NF),2) AS NF
          FROM(SELECT COUNT(A.PID) AS FATALITIES, A.YEAR
          FROM (SELECT p.pid, C.YEAR
          FROM dospina.PERSON P, DOSPINA.collision C
          WHERE p.cid = C.COLLISION_ID AND P.MEDICAL_TREATMENT = 3) A
          GROUP BY A.YEAR
          ORDER BY A.YEAR) X
          NATURAL JOIN
          (SELECT COUNT(A.PID) AS NF, A.YEAR
          FROM (SELECT p.pid, C.YEAR
          FROM dospina.PERSON P, DOSPINA.collision C
          WHERE p.cid = C.COLLISION_ID AND P.MEDICAL_TREATMENT <> 3 AND P.MEDICAL_TREATMENT <> -1) A
          GROUP BY A.YEAR
          ORDER BY A.YEAR) Y
          WHERE YEAR = 2001";

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
  $chart_data .= "{ year:'".$row["YEAR"]."', f:".$row["F"].", nf:".$row["NF"]."}, ";
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
Morris.Bar({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'year',
 ykeys:['f', 'nf'],
 labels:['Fatalities', 'Non-Fatalities'],
 hideHover:'auto',
 stacked:false
});
</script>