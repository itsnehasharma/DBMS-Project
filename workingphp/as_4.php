<?php 

$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$query = "SELECT YEAR, W_1, W_2, W_3, W_4, W_5, W_6, W_7
FROM (SELECT COUNT(A.COLLISION_ID) AS W_1, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 1
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_2, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 2
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_3, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 3
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_4, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 4
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_5, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 5
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_6, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 6
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS W_7, A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 7
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR)
WHERE YEAR BETWEEN 2000 AND 2007";

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
  $chart_data .= "{ year:'".$row["YEAR"]."', w_1:".$row["W_1"].", w_2:".$row["W_2"].", w_3:".$row["W_3"].", w_4:".$row["W_4"].", w_5:".$row["W_5"].", w_6:".$row["W_6"].", w_7:".$row["W_7"]."}, ";
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
   <div id="legend" class="bars-legend"></div>
  </div>
</center>
 </body>
</html>

<script>
var abc = Morris.Bar({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'year',
 ykeys:['w_1','w_2','w_3','w_4','w_5','w_6','w_7'],
 labels:['Clear And Sunny','Overcast','Raining','Snowing','Freezing rain, sleet, hail','Visibility Limitation','Strong Wind'],
 hideHover:'auto',
 stacked:false
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