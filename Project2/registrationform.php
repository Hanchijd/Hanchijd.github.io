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
    Username:<input type="text" class="text_field" name="username" /> <br>
    Password:<input type="password" class="text_field" name="password" /> <br>
    <button class="button" type="submit">Sign-up</button>
  </form>
</body>
</html>
