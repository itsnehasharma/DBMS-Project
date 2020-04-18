<?php

$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";

$c = oci_connect($username, $password, $database);
if (!$c) {
    $m = oci_error();
    trigger_error('Could not connect to database: '. $m['message'], E_USER_ERROR);
}

if (isset($_POST['starting-year']))
{
    $start = $_POST['starting-year'];
}

if (isset($_POST['ending-year']))
{
    $end = $_POST['ending-year'];
}

$query = "SELECT SUM(TOTAL) AS TUPLE
FROM((SELECT COUNT(*) AS TOTAL FROM DOSPINA.COLLISION)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.TRAFFIC_CONTROL)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.ROAD_ALIGNMENT)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.ROAD_SURFACE)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.WEATHER_CONDITIONS)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.ROADWAY_CONFIGURATION)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.MONTH)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.WEEKDAY)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.HOUR)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.SEVERITY)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.COLLISION_CONFIGURATION)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.VEHICLE_TYPE)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.PERSON_POSITION)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.PERSON_SEVERITY)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.PERSON_SAFE)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.PERSON_USER)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.PERSON)
UNION ALL
(SELECT COUNT(*) AS TOTAL FROM DOSPINA.VEHICLE))";

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

$row = oci_fetch_array($s, OCI_BOTH);
$total = $row['TUPLE'];
echo $total;
?>