<?php
session_start(); // Starting Session 
$error = ''; // Variable To Store Error Message 
//if (isset($_POST['submit'])) { 
  if (empty($_POST['username']) || empty($_POST['password'])) { 
    $error = "Username or Password is invalid"; 
  } 
  else{ 
    $username = "shreyans";                   // Use your username
    $password = "Qwerty123";                  // and your password
    $database = "oracle.cise.ufl.edu/orcl";   // and the connect string to connect to your database

    $c = oci_connect($username, $password, $database);
    if (!$c) {
        $m = oci_error();
        trigger_error('Could not connect to database: '. $m['message'], E_USER_ERROR);
    }
    // Define $username and $password 
    $username = $_POST['username']; 
    $password = $_POST['password']; 
    // mysqli_connect() function opens a new connection to the MySQL server. 
    $conn = mysqli_connect("localhost", "root", "", "jobfit"); 
    // SQL query to fetch information of registerd users and finds user match. 
    $query = "SELECT username, password from login where username=? AND password=? LIMIT 1"; 
    // To protect MySQL injection for Security purpose 
   
    $stmt = $conn->prepare($query); 
    $stmt->bind_param("ss", $username, $password); 
    $stmt->execute(); 
    $stmt->bind_result($username, $password); 
    $stmt->store_result(); 

    $user_query = "SELECT user_id from login where username=$username AND password=$password";

    $row= mysqli_fetch_array($user_query);
    $store = $row['store_id'];

    if($stmt->fetch()) //fetching the contents of the row { 
      {
        $_SESSION['login_user'] = $username; // Initializing Session 
      }

    header("location: ../user_det.php"); // Redirecting To Profile Page 
  } 
  //mysqli_close($conn); // Closing Connection 
//} 
?>