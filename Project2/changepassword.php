<?php 
require "session_auth.php"; 
  
function sanitize_input($input) { 
  return htmlspecialchars(trim($input)); 
} 
  
$oldpassword   = sanitize_input($_POST["oldpassword"] ?? ""); 
$newpassword   = sanitize_input($_POST["newpassword"] ?? ""); 
$renewpassword = sanitize_input($_POST["renewpassword"] ?? ""); 
$token         = $_POST["token"] ?? ""; 
  
if ($token !== $_SESSION['token']) { 
  die("CSRF token mismatch. Please try again."); 
} 
  
if ($newpassword !== $renewpassword) { 
  die("New passwords do not match."); 
} 
  
$pass = 'Pa$$w0rd'; 
$mysqli = new mysqli('localhost', 'Hanchijd', $pass, 'waph'); 
if ($mysqli->connect_errno) { 
  die("Database connection failed: " . $mysqli->connect_error); 
} 
  
$sql_check = "SELECT * FROM users WHERE username=? AND password=md5(?)"; 
$stmt_check = $mysqli->prepare($sql_check); 
$stmt_check->bind_param("ss", $_SESSION['username'], $oldpassword); 
$stmt_check->execute(); 
$result = $stmt_check->get_result(); 
  
if ($result->num_rows != 1) { 
  die("Old password incorrect."); 
} 
$stmt_check->close(); 
  
$sql_update = "UPDATE users SET password=md5(?) WHERE username=?"; 
$stmt_update = $mysqli->prepare($sql_update); 
$stmt_update->bind_param("ss", $newpassword, $_SESSION['username']); 
  
if ($stmt_update->execute()) { 
  echo "Password changed successfully! <a href='index.php'>Return to Profile</a>"; 
} else { 
  echo "Password change failed: " . $mysqli->error; 
} 
  
$stmt_update->close(); 
$mysqli->close(); 

unset($_SESSION['token']); 
?> 