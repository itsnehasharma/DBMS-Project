<?php 

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
  $chart_data .= "{ year:'".$row["YEAR"]."', babies:".$row["BABIES"].", toddlers:".$row["TODDLERS"].", kids:".$row["KIDS"].", teenagers:".$row["TEENAGERS"].", young_adults:".$row["YOUNG_ADULTS"].", adults:".$row["ADULTS"].", senior_citizens:".$row["SENIOR_CITIZENS"]."}, ";
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
 ykeys:['babies','toddlers','kids','teenagers','young_adults','adults','senior_citizens'],
 labels:['Babies','Toddlers','Kids','Teenagers','Young Adults','Adults','Senior Citizens'],
 hideHover:'auto',
 stacked:false
});
</script>