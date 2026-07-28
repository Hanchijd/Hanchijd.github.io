# Source code to Markdown
This file is automatically created by a script. Please delete this line and replace with the course and your team information accordingly.
## /form.php
```php
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH-Login page</title>
  <script type="text/javascript">
      function displayTime() {
        const options = {
          month: 'short', // 'Jun'
          day: '2-digit', // '24'
          hour: '2-digit', // '07'
          minute: '2-digit', // '03'
          second: '2-digit', // '45'
          hour12: true // 'am'
        };
        const formattedTime = new Date().toLocaleString('en-US', options).replace(/,/, '');
        document.getElementById('digit-clock').innerHTML = "Current time: " + formattedTime;
      }
      setInterval(displayTime,500);
  </script>
</head>
<body>
  <h1>A Simple login form, WAPH</h1>
  <h2>Student Name</h2>
  <div id="digit-clock"></div>  
<?php
  //some code here
  echo "Visited time: " . date("M-d h:i:sa")
?>
  <form action="index.php" method="POST" class="form login">
    Username:<input type="text" class="text_field" name="username" /> <br>
    Password: <input type="password" class="text_field" name="password" /> <br>
    <button class="button" type="submit">Login</button>
  </form>
</body>
</html>

```
## /editprofileform.php
```php
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

```
## /addnewuser.php
```php
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
```
## /session_auth.php
```php
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
```
## /registrationform.php
```php
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sign Up for a new account</title>
  <script type="text/javascript">
      function displayTime() {
        const options = {
          month: 'short', // 'Jun'
          day: '2-digit', // '24'
          hour: '2-digit', // '07'
          minute: '2-digit', // '03'
          second: '2-digit', // '45'
          hour12: true // 'am'
        };
        const formattedTime = new Date().toLocaleString('en-US', options).replace(/,/, '');
        document.getElementById('digit-clock').innerHTML = "Current time: " + formattedTime;
      }
      setInterval(displayTime,500);
  </script>
</head>
<body>
  <h1>New user registration, WAPH</h1>
  <h2>Jack Hanchin</h2>
  <div id="digit-clock"></div>  
<?php
  //some code here
  echo "Visited time: " . date("M-d h:i:sa")
?>
  <form action="addnewuser.php" method="POST" class="form login"> 
 Username: 
 <input type="text" name="username" required pattern="\w+"  
        title="Letters, numbers, and underscores only"><br> 
 
 Password: 
 <input type="password" name="password" required 
        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&]).{8,}$" 
        title="At least 8 characters with 1 uppercase, 1 lowercase, 1 number, and 1 special symbol"><br> 
 
 Retype Password: 
 <input type="password" name="repassword" required title="Passwords must match"><br> 
 
 Full Name: 
 <input type="text" name="fullname" required pattern="[A-Za-z ]+"  
        title="Letters and spaces only"><br> 
 
 Email: 
 <input type="email" name="email" required  
        title="Enter a valid email address"><br> 
 
 <button type="submit">Sign Up</button> 
</form> 
</body>
</html>
```
## /changepasswordform.php
```php
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
```
## /index.php
```php
<?php 
session_start(); 
  
if (isset($_POST["username"]) && isset($_POST["password"])) { 
    if (checklogin_mysql($_POST["username"], $_POST["password"])) { 
        $_SESSION['authenticated'] = TRUE; 
        $_SESSION['username'] = $_POST["username"];
        $_SESSION['browser'] = $_SERVER['HTTP_USER_AGENT'];
        header("Location: index.php"); // reload page after login 
        exit(); 
    } else { 
        session_destroy(); 
        echo "<script>alert('Invalid username/password');window.location='form.php';</script>"; 
        die(); 
    } 
} 
  
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] != TRUE) { 
    session_destroy(); 
    echo "<script>alert('You have not logged in, please log in first!');window.location='form.php';</script>"; 
    die(); 
}

require "session_auth.php";

function checklogin_mysql($username, $password) { 
    $pass = 'Pa$$w0rd'; 
    $mysqli = new mysqli('localhost', 'Hanchijd', $pass, 'waph'); 
    if ($mysqli->connect_errno) { 
        printf("Database connection failed: %s\n", $mysqli->connect_error); 
        exit(); 
    } 
  
    $sql = "SELECT * FROM users WHERE username=? AND password = md5(?)"; 
    $stmt = $mysqli->prepare($sql); 
    $stmt->bind_param("ss", $username, $password); 
    $stmt->execute(); 
    $result = $stmt->get_result(); 
  
    return ($result->num_rows == 1); 
} 
?> 
  
<h2>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</h2> 

  <script> 
  window.addEventListener("DOMContentLoaded", () => { 
    const username = "<?php echo htmlentities($_SESSION['username']); ?>"; 
    const message = `Welcome back, ${username}!`; 
    const popup = document.createElement("div"); 
    popup.textContent = message; 
    popup.style.position = "fixed"; 
    popup.style.top = "20px"; 
    popup.style.right = "20px"; 
    popup.style.backgroundColor = "#0078D7"; 
    popup.style.color = "white"; 
    popup.style.padding = "10px 20px"; 
    popup.style.borderRadius = "5px"; 
    popup.style.boxShadow = "0 2px 6px rgba(0,0,0,0.3)"; 
    popup.style.fontFamily = "Segoe UI, sans-serif"; 
    popup.style.zIndex = "1000"; 
    document.body.appendChild(popup); 
    setTimeout(() => popup.remove(), 3000); // disappears after 3 seconds 
  }); 
</script>

<?php 
// Step 4: Display profile info 
$pass = 'Pa$$w0rd'; 
$mysqli = new mysqli('localhost', 'Hanchijd', $pass, 'waph'); 
  
$sql = "SELECT fullname, email FROM users WHERE username = ?"; 
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $_SESSION['username']); 
$stmt->execute(); 
$stmt->bind_result($fullname, $email); 
  
if ($stmt->fetch()) { 
    echo "<p><strong>Full Name:</strong> " . htmlentities($fullname) . "</p>"; 
    echo "<p><strong>Email:</strong> " . htmlentities($email) . "</p>"; 
} else { 
    echo "<p>No profile information found.</p>"; 
} 
  
$stmt->close(); 
$mysqli->close(); 
?> 
  
<a href="changepasswordform.php">Change Password</a>
<a href="logout.php">Logout</a> <?php 
session_start(); 
  
if (isset($_POST["username"]) && isset($_POST["password"])) { 
    if (checklogin_mysql($_POST["username"], $_POST["password"])) { 
        $_SESSION['authenticated'] = TRUE; 
        $_SESSION['username'] = $_POST["username"]; 
        header("Location: index.php"); // reload page after login 
        exit(); 
    } else { 
        session_destroy(); 
        echo "<script>alert('Invalid username/password');window.location='form.php';</script>"; 
        die(); 
    } 
} 
  
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] != TRUE) { 
    session_destroy(); 
    echo "<script>alert('You have not logged in, please log in first!');window.location='form.php';</script>"; 
    die(); 
} 
```
## /changepassword.php
```php
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
```
## /editprofile.php
```php
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
```
