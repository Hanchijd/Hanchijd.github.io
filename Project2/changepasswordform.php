<?php 
require "session_auth.php"; 
 
// Generate CSRF token 
if (empty($_SESSION['token'])) { 
 $_SESSION['token'] = bin2hex(random_bytes(32)); 
} 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
 <meta charset="UTF-8"> 
 <title>Change Password</title> 
</head> 
<body> 
 <h2>Change Password for <?php echo htmlentities($_SESSION['username']); ?></h2> 
 
 <form action="changepassword.php" method="POST"> 
   <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"> 
   <label>Old Password:</label> 
   <input type="password" name="oldpassword" required><br> 
 
   <label>New Password:</label> 
   <input type="password" name="newpassword" required 
          pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&]).{8,}$" 
          title="At least 8 characters with uppercase, lowercase, number, and special symbol"><br> 
 
   <label>Retype New Password:</label> 
   <input type="password" name="renewpassword" required><br> 
 
   <button type="submit">Change Password</button> 
 </form> 
 
 <a href="index.php">Back to Profile</a> 
</body> 
</html> 