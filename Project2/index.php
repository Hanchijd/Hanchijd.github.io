<!--<?php 
//	ini_set('display_errors', 1);
//	error_reporting(E_ALL);
?>-->
<?php
	session_start();  
	if (isset($_POST["username"]) and isset($_POST["password"])) {
		$_SESSION['authenticated'] = TRUE;
		$_SESSION['username'] = $_POST["username"];

		if (checklogin_mysql($_POST["username"],$_POST["password"])) {
		}else{
			session_destroy();
			echo "<script>alert('Invalid username/password');window.location='form.php';</script>";
			die();
		}
	}
	if (!isset($_SESSION["authenticated"]) or $_SESSION["authenticated"]!= TRUE) {
		session_destroy();
		echo "<script>alert('You have not logged in, please log in first!');window.location='form.php';</script>";
		header("Refresh: 0; url=form.php");
		die();
	}
	<h2>Welcome <?php echo htmlentities($_SESSION['username']); </h2> 
		$pass = 'Pa$$w0rd'; 
		$mysqli = new mysqli('localhost', 'Hanchijd', $pass, 'waph'); 
		if ($mysqli->connect_errno) { 
		  die("Database connection failed: " . $mysqli->connect_error); 
		} 
		  
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
  
<a href="changepasswordform.php">Change Password</a> | 
<a href="logout.php">Logout</a> 

	function checklogin($username, $password) {
		$account = array("admin","1234");
		if (($username== $account[0]) and ($password == $account[1])) 
		  return TRUE;
		else 
		  return FALSE;
  	}
  	function checklogin_mysql($username, $password) {
  		$pass = 'Pa$$w0rd';
		$mysqli = new mysqli('localhost','Hanchijd', $pass, 'waph');
		if ($mysqli->connect_errno){
			printf("Database connection failed: %s\n", $mysqli->connect_error);
			exit();
		} 
		$sql = "SELECT * FROM users WHERE username=? AND password = md5(?)";
		//echo "DEBUG>sql= $sql"; //return TRUE;
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();//$result = $mysqli->query($sql);
		if($result->num_rows ==1)
			return TRUE;
		return FALSE;
		/*$sql = "SELECT * FROM users where username='" . $username . "' AND password = md5('" . $password . "');";
		$result = $mysqli->query($sql);
		if($result->num_rows ==1) return TRUE;
		return FALSE;*/
  	}
?>

		<h2> Welcome <?php echo htmlentities($_SESSION['username']); ?> !</h2>
		<a href="logout.php">Logout</a>