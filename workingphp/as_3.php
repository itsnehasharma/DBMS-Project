<?php 

$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$query = "SELECT MONTH, AM, AA, AE, AN
FROM
(SELECT A.MORNING AS AM, B.DESCRIPTION AS MONTH
FROM
(SELECT COUNT(*) AS MORNING, MONTH
FROM DOSPINA.collision C
WHERE c.hour BETWEEN 6 AND 11 AND YEAR = 2001 AND MONTH <> -1
GROUP BY MONTH
ORDER BY MONTH) A,
(SELECT DESCRIPTION, MONTH_ID
FROM DOSPINA.MONTH 
WHERE MONTH_ID <> -1) B
WHERE A.MONTH = B.MONTH_ID)
NATURAL JOIN
(SELECT A.AFTERNOON AS AA, B.DESCRIPTION AS MONTH
FROM
(SELECT COUNT(*) AS AFTERNOON, MONTH
FROM DOSPINA.collision C
WHERE c.hour BETWEEN 12 AND 16 AND YEAR = 2001 AND MONTH <> -1
GROUP BY MONTH
ORDER BY MONTH) A,
(SELECT DESCRIPTION, MONTH_ID
FROM DOSPINA.MONTH 
WHERE MONTH_ID <> -1) B
WHERE A.MONTH = B.MONTH_ID)
NATURAL JOIN
(SELECT A.EVENING AS AE, B.DESCRIPTION AS MONTH
FROM
(SELECT COUNT(*) AS EVENING, MONTH
FROM DOSPINA.collision C
WHERE c.hour BETWEEN 17 AND 19 AND YEAR = 2001 AND MONTH <> -1
GROUP BY MONTH
ORDER BY MONTH) A,
(SELECT DESCRIPTION, MONTH_ID
FROM DOSPINA.MONTH 
WHERE MONTH_ID <> -1) B
WHERE A.MONTH = B.MONTH_ID)
NATURAL JOIN
(SELECT N1+N2 AS AN, MONTH
FROM
(SELECT A.NIGHT AS N1, B.DESCRIPTION AS MONTH
FROM
(SELECT COUNT(*) AS NIGHT, MONTH
FROM DOSPINA.collision C
WHERE c.hour BETWEEN 20 AND 23 AND YEAR = 2001 AND MONTH <> -1
GROUP BY MONTH
ORDER BY MONTH) A,
(SELECT DESCRIPTION, MONTH_ID
FROM DOSPINA.MONTH 
WHERE MONTH_ID <> -1) B
WHERE A.MONTH = B.MONTH_ID) 
NATURAL JOIN
(SELECT A.NIGHT AS N2, B.DESCRIPTION AS MONTH
FROM
(SELECT COUNT(*) AS NIGHT, MONTH
FROM DOSPINA.collision C
WHERE c.hour BETWEEN 0 AND 5 AND YEAR = 2001 AND MONTH <> -1
GROUP BY MONTH
ORDER BY MONTH) A,
(SELECT DESCRIPTION, MONTH_ID
FROM DOSPINA.MONTH 
WHERE MONTH_ID <> -1) B
WHERE A.MONTH = B.MONTH_ID))";

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
  $chart_data .= "{ month:'".$row["MONTH"]."', am:".$row["AM"].", aa:".$row["AA"].", ae:".$row["AE"].", an:".$row["AN"]."}, ";
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
 xkey:'month',
 ykeys:['am','aa','ae','an'],
 labels:['Accident in Morning','Accident in Afternoon','Accident in Evening','Accident in Night'],
 hideHover:'auto',
 stacked:false
});
</script>