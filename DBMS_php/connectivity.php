<?php

  $username = "rruchir";                   // Use your username
  $password = "pubgislove";                 // and your password
  $database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database
 
  $query = "INSERT INTO test_data values('First','Last')";

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

?>