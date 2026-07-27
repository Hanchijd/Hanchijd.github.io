<?php 
require "session_auth.php"; 
  
if (empty($_SESSION['token'])) { 
  $_SESSION['token'] = bin2hex(random_bytes(32)); 
} 
   
$pass = 'Pa$$w0rd'; 
$mysqli = new mysqli('localhost', 'Hanchijd', $pass, 'waph'); 
$sql = "SELECT fullname, email FROM users WHERE username=?"; 
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $_SESSION['username']); 
$stmt->execute(); 
$stmt->bind_result($fullname, $email); 
$stmt->fetch(); 
$stmt->close(); 
$mysqli->close(); 
?> 
  
<!DOCTYPE html> 
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <title>Edit Profile</title> 
</head> 
<body> 
  <h2>Edit Profile for <?php echo htmlentities($_SESSION['username']); ?></h2> 
  
  <form action="editprofile.php" method="POST"> 
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"> 
    <label>Full Name:</label> 
    <input type="text" name="fullname" value="<?php echo htmlentities($fullname); ?>" required><br> 
  
    <label>Email:</label> 
    <input type="email" name="email" value="<?php echo htmlentities($email); ?>" required><br> 
  
    <button type="submit">Save Changes</button> 
  </form> 
  
  <a href="index.php">Back to Profile</a> 
</body> 
</html> 
