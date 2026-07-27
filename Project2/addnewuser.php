<?php
	$username = $_POST["username"];
	$password = $_POST["password"];
	if (isset($username) and isset($password)){
		//echo "Debug> got username=$username;password=$password";
		if (addnewuser($username,$password)){
			echo "Registration succeed!";
		}else{
			echo "Registration failed!";

		}
	}else{
		echo "No username/password provided!";
	}

  	function addnewuser($username, $password) {
  		$pass = 'Pa$$w0rd'; $mysqli = new mysqli('localhost','Hanchijd', $pass, 'waph'); echo "Line 17"; 
		if ($mysqli->connect_errno){
			printf("Database connection failed: %s\n", $mysqli->connect_error);
			echo "Line 20";
		} 
		$prepared_sql = "INSERT INTO users (username,password) VALUES (?,md5(?))";
	$check = $mysqli->prepare("SELECT 1 FROM users WHERE username = ?"); 
	$check->bind_param("s", $username); 
	$check->execute(); echo "$check->error";
	if ($check->get_result()->num_rows > 0) { 
	    echo "Username already taken!"; 
	    return FALSE; 
	}
	 
	$stmt = $mysqli->prepare($prepared_sql); 
	$stmt->bind_param("ss", $username, $password); 
	if ($stmt->execute()) return TRUE; 
	echo "Line 25 Failed"; return FALSE;  	}
?>