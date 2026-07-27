<?php 
require "session_auth.php"; 
  
function sanitize_input($input) { 
  return htmlspecialchars(trim($input)); 
} 
  
$fullname = sanitize_input($_POST["fullname"] ?? ""); 
$email    = sanitize_input($_POST["email"] ?? ""); 
$token    = $_POST["token"] ?? ""; 
  
if ($token !== $_SESSION['token']) { 
  die("CSRF token mismatch. Please try again."); 
} 
  
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
  die("Invalid email format."); 
} 
  
$pass = 'Pa$$w0rd'; 
$mysqli = new mysqli('localhost', 'Hanchijd', $pass, 'waph'); 
if ($mysqli->connect_errno) { 
  die("Database connection failed: " . $mysqli->connect_error); 
} 
  
$sql = "UPDATE users SET fullname=?, email=? WHERE username=?"; 
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("sss", $fullname, $email, $_SESSION['username']); 
  
if ($stmt->execute()) { 
  echo "Profile updated successfully! <a href='index.php'>Return to Profile</a>"; 
} else { 
  echo "Profile update failed: " . $mysqli->error; 
} 
  
$stmt->close(); 
$mysqli->close(); 
unset($_SESSION['token']); 

?> 