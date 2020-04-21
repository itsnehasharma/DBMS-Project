<?php
session_start(); 
if(session_destroy()) // Destroying All Sessions { 
  header("Location: login_v3.php"); // Redirecting To Home Page 
?>