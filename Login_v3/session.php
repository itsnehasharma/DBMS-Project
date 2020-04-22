<?php
// mysqli_connect() function opens a new connection to the MySQL server. 
$username = "shreyans";                   // Use your username
$password = "Qwerty123";                  // and your password
$database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

$c = oci_connect($username, $password, $database);
if (!$c) {
    $m = oci_error();
    trigger_error('Could not connect to database: '. $m['message'], E_USER_ERROR);
}

session_start();// Starting Session 
// Storing Session 
$user_check = $_SESSION['login_user']; 
// SQL Query To Fetch Complete Information Of User 
$query = "SELECT username from login where username = '$user_check'";
$s = oci_parse($c, $query);
$r = oci_execute($s);

$row = oci_fetch_array($s, OCI_BOTH)

$login_session = $row['username'];
?>