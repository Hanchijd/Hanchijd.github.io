<style> /* Button Format */
 .back-button { 
   background-color: #0078D7; /* Microsoft blue */ 
   color: white; 
   border: none; 
   padding: 10px 18px; 
   border-radius: 5px; 
   font-size: 14px; 
   cursor: pointer; 
   transition: background-color 0.3s ease; 
 } 
 
 .back-button:hover { 
   background-color: #005A9E; /* darker blue on hover */ 
 } 
</style> 

<?php 
// addnewuser.php — Secure user registration for WAPH Individual Project 2 
  
function sanitize_input($input) { 
  $input = trim($input); 
  $input = stripslashes($input); 
  $input = htmlspecialchars($input); 
  return $input; 
} 
  
// Get and sanitize inputs 
$username   = sanitize_input($_POST["username"] ?? ""); 
$password   = sanitize_input($_POST["password"] ?? ""); 
$repassword = sanitize_input($_POST["repassword"] ?? ""); 
$fullname   = sanitize_input($_POST["fullname"] ?? ""); 
$email      = sanitize_input($_POST["email"] ?? ""); 
  
// Validate inputs 
if (empty($username) || empty($password) || empty($repassword) || empty($fullname) || empty($email)) { 
  die('All fields are required. Please go back and fill out the form.<br> 
  	<button class="back-button" onclick="window.location.href=\'registrationform.php\'">Go Back</button>'); 
} 
  
if ($password !== $repassword) { 
  die("Passwords do not match. Please go back and try again."); 
} 
  
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
  die("Invalid email format. Please go back and enter a valid email."); 
} 
  
// Connect to database 
$mysqli = new mysqli('localhost', 'Hanchijd', 'Pa$$w0rd', 'waph'); 
if ($mysqli->connect_errno) { 
  die("Database connection failed: " . $mysqli->connect_error); 
} 
  
// Check for duplicate username 
$check_sql = "SELECT username FROM users WHERE username = ?"; 
$check_stmt = $mysqli->prepare($check_sql); 
$check_stmt->bind_param("s", $username); 
$check_stmt->execute(); 
$check_stmt->store_result(); 
  
if ($check_stmt->num_rows > 0) { 
  die("Username already exists. Please choose another."); 
} 
$check_stmt->close(); 
  
// Insert new user securely 
$insert_sql = "INSERT INTO users (username, password, fullname, email) VALUES (?, md5(?), ?, ?)"; 
$insert_stmt = $mysqli->prepare($insert_sql); 
$insert_stmt->bind_param("ssss", $username, $password, $fullname, $email); 
  
if ($insert_stmt->execute()) { 
  echo "Registration successful! You can now <a href='form.php'>login</a>."; 
} else { 
  echo "Registration failed: " . $mysqli->error; 
} 
  
$insert_stmt->close(); 
$mysqli->close(); 
?> 