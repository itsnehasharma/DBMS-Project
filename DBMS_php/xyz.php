<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
 
$username = "shreyans";                   // Use your username
  $password = "Qwerty123";                 // and your password
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

$num_count = 0;
while($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)){

            $year = $row['YEAR'];
            $male = $row['MALE'];
            $female = $row['FEMALE'];
            
            echo "['".$year."', '".$male."', '".$female."']";     
            echo "<br>";
            if ($num_count < 16) {
              echo ",";
            }
          }
?>