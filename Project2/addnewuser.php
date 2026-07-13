<?php
	$username = $_POST['username'];
	$password = $_POST['password'];
	if (isset($_POST["username"]) and isset($_POST["password"])) {
		echo "Debug> got username=$username;password=$password";
		/*if (checklogin_mysql($_POST["username"],$_POST["password"])) {
		$_SESSION['authenticated'] = TRUE;
		$_SESSION['username'] = $_POST["username"];
		}else{
			session_destroy();
			echo "<script>alert('Invalid username/password');window.location='form.php';</script>";
			die();
		}*/
	}else{
		echo "No username/passworld provided!";
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
  	}
?>