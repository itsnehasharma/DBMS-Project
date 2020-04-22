<?php

$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$c = oci_connect($username, $password, $database);
if (!$c) {
    $m = oci_error();
    trigger_error('Could not connect to database: '. $m['message'], E_USER_ERROR);
}

$username = ($_POST['username']);		//Mandatory
$password = ($_POST['password']);		//Mandatory

if ($username==""||$password==""||$name==""||$email=="") {
	# code...
	echo "<script>
		alert('Complete all data fields');
		history.back();
	</script>";
}else{
	$query = "INSERT INTO login values('$username',$password)";
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

	echo"<script>
		window.location.href='login_v3.php';
	</script>";
}

?>

<?php 
/*
$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$query = "";

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
*/
?>