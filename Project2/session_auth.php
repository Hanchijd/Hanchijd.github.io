<?php 
$lifetime = 15 * 60; // 15 minutes 
$path = "/"; 
$domain = "192.168.56.101"; // replace with your server IP or hostname 
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
    // Session hijacking protection 
    session_destroy(); 
    echo "<script>alert('Session hijacking attack detected!');</script>"; 
    header("Refresh:0; url=form.php"); 
    die(); 
} 
?>