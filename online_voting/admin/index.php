<?php
    session_start();

    $myusername = isset($_SESSION['nam']) ? htmlspecialchars($_SESSION['nam']) : "";
    $mypassword = isset($_SESSION['pas']) ? htmlspecialchars($_SESSION['pas']) : "";


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login Form</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

  <link rel="stylesheet" href="css/style.css">
  <script language="JavaScript" src="js/admin.js"></script>
</head>

<body style="background-image:url('images/demo/backgrounds/wellcome.png');">

<div class="pen-title">
  <h1>Admin Login Form</h1>
</div>

<div class="container"> 
  <div class="card"></div>
  
  <div class="card">
    <h1 class="title">Login</h1>
    <form name="form1" action="checklogin.php" method="post" onsubmit="return loginValidate(this)">

      <div class="input-container">
        <input name="myusername" value="<?php echo $myusername; ?>" type="text" required="required"/>
        <label for="myusername">Email</label>
        <div class="bar"></div>
      </div>
      
      <div class="input-container">
        <input name="mypassword" value="<?php echo $mypassword; ?>" type="password" required="required"/>
        <label for="mypassword">Password</label>
        <div class="bar"></div>
      </div>

      <!-- Fixed HTML Structure: Replaced <tr><td> with Divs and proper styling -->
      <div style="text-align: center; margin: 15px 0;">
        <input type="checkbox" name="remember" id="remember" value="1">
        <label for="remember" style="color: blue;">Remember Me</label>
      </div>

      <div class="button-container">
        <button name="Submit" type="submit"><span>Login</span></button>
      </div>
      
      <br><br>
      <div style="text-align: center;">
        Return to <a href="../voter.php">Voter Panel</a>
      </div>

    </form>
  </div>
  
</div>

</body>
</html>