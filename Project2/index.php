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