<?php 

$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$query = "SELECT ROWNUM, *
FROM (SELECT M_S, M_WS
FROM (SELECT COUNT(*) AS M_S
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position = 99 AND p.safety_device_used = 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 6 AND 11) ,
(SELECT COUNT(*) AS M_WS
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position=99 AND p.safety_device_used <> 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 6 AND 11)) A
UNION
(SELECT A_S, A_WS
FROM(SELECT COUNT(*) AS A_S
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position = 99 AND p.safety_device_used = 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 12 AND 16) ,
(SELECT COUNT(*) AS A_WS
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position=99 AND p.safety_device_used <> 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 12 AND 16) )
UNION
(SELECT E_S, E_WS
FROM (SELECT COUNT(*) AS E_S
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position = 99 AND p.safety_device_used = 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 17 AND 19),
(SELECT COUNT(*) AS E_WS
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position=99 AND p.safety_device_used <> 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 17 AND 19))
UNION
(SELECT N_S, N_WS
FROM (SELECT A.NIGHT_S + B.NIGHT_S AS N_S
FROM (SELECT COUNT(*) AS NIGHT_S
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position = 99 AND p.safety_device_used = 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 20 AND 23) A,
(SELECT COUNT(*) AS NIGHT_S
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position=99 AND p.safety_device_used = 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 0 AND 5) B) I,
(SELECT A.NIGHT_WS + B.NIGHT_WS AS N_WS
FROM (SELECT COUNT(*) AS NIGHT_WS
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position = 99 AND p.safety_device_used <> 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 20 AND 23) A,
(SELECT COUNT(*) AS NIGHT_WS
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position=99 AND p.safety_device_used <> 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 0 AND 5) B) J)
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
  $chart_data .= "{ year:'".$row["YEAR"]."', male:".$row["MALE"].", female:".$row["FEMALE"]."}, ";
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
 ykeys:['male', 'female'],
 labels:['Male', 'Female'],
 hideHover:'auto',
 stacked:false
});
</script>