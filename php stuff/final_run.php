<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
 
$username = "USERNAME";                   // Use your username
  $password = "PASSWORD";                 // and your password
  $database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database
 
$query = "SELECT *
  FROM (SELECT COUNT(ROWNUM) AS MALE, C.YEAR
  FROM DOSPINA.person P, DOSPINA.collision C
  WHERE P.CID = C.COLLISION_ID AND P.SEX <> '-1' AND p.position = 11 AND p.sex = 'M'
  GROUP BY c.year
  ORDER BY c.year) A NATURAL JOIN
  (SELECT COUNT(ROWNUM) AS FEMALE, C.YEAR
  FROM DOSPINA.person P, DOSPINA.collision C
  WHERE P.CID = C.COLLISION_ID AND P.SEX <> '-1' AND p.position = 11 AND p.sex = 'F'
  GROUP BY c.year
  ORDER BY c.year) B";
 
$c = oci_connect($username, $password, $database);
 
$s = oci_parse($c, $query);

$r = oci_execute($s);




/*
$count = oci_fetch_all($s, $result, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);
for ($i = 0; $i < $count; $i++) {
    echo 'Field 1: ' . $result[$i]['FIELD1'] . '<br>Field 2: ' . $result[$i]['FIELD2'] . '<br>';
  }
*/



?>

<html>
<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Year');
      data.addColumn('number', 'Male');
      data.addColumn('number', 'Female');
      //data.addColumn('number', 'Transformers: Age of Extinction');

      data.addRows([
        while($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)){


          $year = $row['YEAR'];
          $male = $row['MALE'];
          $female = $row['FEMALE'];
          
          echo "['".$year."', '".$male."', ['".$female."'],";     
          echo "<br>";  
        }

        /*
        [1,  37.8, 80.8, 41.8],
        [2,  30.9, 69.5, 32.4],
        [3,  25.4,   57, 25.7],
        [4,  11.7, 18.8, 10.5],
        [5,  11.9, 17.6, 10.4],
        [6,   8.8, 13.6,  7.7],
        [7,   7.6, 12.3,  9.6],
        [8,  12.3, 29.2, 10.6],
        [9,  16.9, 42.9, 14.8],
        [10, 12.8, 30.9, 11.6],
        [11,  5.3,  7.9,  4.7],
        [12,  6.6,  8.4,  5.2],
        [13,  4.8,  6.3,  3.6],
        [14,  4.2,  6.2,  3.4]*/
      ]);

      var options = {
        chart: {
          title: 'Box Office Earnings in First Two Weeks of Opening',
          subtitle: 'in millions of dollars (USD)'
        },
        width: 900,
        height: 500,
        axes: {
          x: {
            0: {side: 'top'}
          }
        }
      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
  </script>
</head>
<body>
  <div id="line_top_x"></div>
</body>
</html>
