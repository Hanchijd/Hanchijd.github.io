<?php 
$lifetime = 15 * 60;
$path = "/"; 
$domain = "192.150.145.11";
$secure = TRUE; 
$httponly = TRUE; 
  
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly); 
session_start(); 
  
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] != TRUE) { 
    session_destroy(); 
    echo "<script>alert('You have not logged in. Please login first');</script>"; 
    header("Refresh:0; url=form.php"); 
    die(); 
} 
  
if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) { 
    session_destroy(); 
    echo "<script>alert('Session hijacking attack detected!');</script>"; 
    header("Refresh:0; url=form.php"); 
    die(); 
} 
?>