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