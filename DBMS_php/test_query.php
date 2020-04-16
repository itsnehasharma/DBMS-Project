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
/*
echo "<table border='1'>\n";
$ncols = oci_num_fields($s);
echo "<tr>\n";
for ($i = 1; $i <= $ncols; ++$i) {
    $colname = oci_field_name($s, $i);
    echo "  <th><b>".htmlspecialchars($colname,ENT_QUOTES|ENT_SUBSTITUTE)."</b></th>\n";
}
echo "</tr>\n";
*/

//$num_of_items = count($r);
//echo $num_of_items;


/*while ($row = oci_fetch_array($s,OCI_ASSOC+OCI_RETURN_NULLS )) {

    echo "[";
    echo "'";
    echo $row['YEAR'];echo "', ";
    echo $row['MALE'];echo ", ";
    echo $row['FEMALE'];
    echo "]";
    $num_count = $num_count + 1;

    if ($num_count < 16) {
        echo ",";
    }
    echo "<br>";
}*/

//echo "<table>";

$num_count = 0;
while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
    $num_count = $num_count + 1;
    //echo "<tr>\n";
    echo "[";
    foreach ($row as $item) {
        //echo "<td>";
        echo $item!==null?htmlspecialchars($item, ENT_SUBSTITUTE):"&nbsp;";
        echo ", ";
        //echo "</td>\n";

    }
    echo "]";
    if ($num_count < 16) {
        echo ",";
    }
    echo "<br>";
    //echo "</tr>\n";
    
}
//echo "</table>\n";
//$row1 = oci_fetch_array($s,OCI_ASSOC+OCI_RETURN_NULLS );
//$num_of_items = count($row1);
//echo $num_of_items;


                

?>

