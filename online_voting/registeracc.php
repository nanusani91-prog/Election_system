<?php
require('connection.php'); // Include DB connection

 $message = ""; 

if (isset($_POST['submit'])) {
    // Retrieve inputs
    $myFirstName = $_POST['firstname'];
    $myLastName  = $_POST['lastname'];
    $myEmail     = $_POST['email'];
    $myVoterid   = $_POST['voter_id'];
    $myPassword  = $_POST['password'];
    $confirmPass = $_POST['ConfirmPassword'];

    // Validation: Check if passwords match
    if ($myPassword !== $confirmPass) {
        $message = "<center><h3 style='color:red;'>Passwords do not match.</h3></center>";
    } else {
        // Encrypt password using MD5 (Kept for compatibility with existing database)
        $newpass = md5($myPassword);

        // Secure Insert using Prepared Statements
        $stmt = $mysqli->prepare("INSERT INTO tbmembers (first_name, last_name, email, voter_id, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $myFirstName, $myLastName, $myEmail, $myVoterid, $newpass);

        if ($stmt->execute()) {
            $stmt->close();
            // Stop script and show success message
            die("<center><h3>Registration successful.</h3>
                 <br>Go to <a href='login.php'>Login</a></center>");
        } else {
            $message = "<center><h3 style='color:red;'>Error registering user: " . $stmt->error . "</h3></center>";
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>online voting</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<script language="JavaScript" src="js/user.js"></script>
</head>

<body id="top">

<div class="wrapper row0">
  <div id="topbar" class="hoc clear">
    <div class="fl_left">
      <ul class="faico clear">
        <li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a class="faicon-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
      </ul>
    </div>
    <div class="fl_right">
      <ul class="nospace inline pushright">
        <li><i class="fa fa-phone"></i> +251916175413</li>
        <li><i class="fa fa-envelope-o"></i> gruop3@gmail.com</li>
      </ul>
    </div>
  </div>
</div>

<div class="wrapper row1">
  <header id="header" class="hoc clear">
    <div id="logo" class="fl_left">
      <h1><a href="index.php">ONLINE VOTING</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>
</div>

<div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/wellcome.png');">
  <section id="testimonials" class="hoc container clear">
    <h2 class="font-x3 uppercase btmspace-80 underlined">Online <a href="#">Voting</a></h2>

    <ul class="nospace group">
      <li class="one_half">
        <blockquote>

          <?php if($message != "") { echo $message; } ?>

          <center><h3>Register an account by filling in the needed information below:</h3></center>
          
          <!-- Form wrapped correctly around the table -->
          <form name="form1" method="post" action="" onSubmit="return registerValidate(this)">
  <table style="background-color:brown; width:100%; max-width:400px; margin:0 auto; color:#ffffff;"
         border="0" align="center" cellpadding="6" cellspacing="1">

    <tr>
      <td width="120" style="color:blue;">First Name</td>
      <td style="color:blue;">:</td>
      <td>
        <input name="firstname" type="text" required
               style="width:100%; padding:6px; background-color:#ffffff; color:#000000; border:1px solid #ccc;">
      </td>
    </tr>

    <tr>
      <td style="color:blue;">Last Name</td>
      <td style="color:blue;">:</td>
      <td>
        <input name="lastname" type="text" required
               style="width:100%; padding:6px; background-color:#ffffff; color:#000000; border:1px solid #ccc;">
      </td>
    </tr>

    <tr>
      <td style="color:blue;">Email</td>
      <td style="color:blue;">:</td>
      <td>
        <input name="email" type="email" required
               style="width:100%; padding:6px; background-color:#ffffff; color:#000000; border:1px solid #ccc;">
      </td>
    </tr>

    <tr>
      <td style="color:blue;">Voter Id</td>
      <td style="color:blue;">:</td>
      <td>
        <input name="voter_id" type="text" required
               style="width:100%; padding:6px; background-color:#ffffff; color:#000000; border:1px solid #ccc;">
      </td>
    </tr>

    <tr>
      <td style="color:blue;">Password</td>
      <td style="color:blue;">:</td>
      <td>
        <input name="password" type="password" required
               style="width:100%; padding:6px; background-color:#ffffff; color:#000000; border:1px solid #ccc;">
      </td>
    </tr>

    <tr>
      <td style="color:blue;">Confirm Password</td>
      <td style="color:blue;">:</td>
      <td>
        <input name="ConfirmPassword" type="password" required
               style="width:100%; padding:6px; background-color:#ffffff; color:#000000; border:1px solid #ccc;">
      </td>
    </tr>

    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="submit" value="Register Account"
               style="background-color:#56AED4; color:#ffffff; border:none; padding:8px 16px; cursor:pointer;">
      </td>
    </tr>

  </table>
</form>

<center style="color:#ffffff; margin-top:10px;">
  <br>Already have an account?
  <a href="login.php" style="color:#56AED4;"><b>Login Here</b></a>
</center>

        </blockquote>
      </li>
    </ul>
  </section>
</div>

<div class="wrapper row4">
  <footer id="footer" class="hoc clear">
    <div class="one_third first">
      <h6 class="title">Address</h6>
      <p>
        Name: Md. Grou 3<br>
        University: Debre Berhan<br>
        Dept: IT
      </p>
    </div>

    <div class="one_third">
      <h6 class="title">Phone</h6>
      <p>+251916175413</p>
    </div>

    <div class="one_third">
      <h6 class="title">Email</h6>
      <p>gruop3.rh@gmail.com</p>
    </div>
  </footer>
</div>

<div class="wrapper row5">
  <div id="copyright" class="hoc clear">
    <p class="fl_left">Copyright © 2026</p>
  </div>
</div>

<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>

<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.placeholder.min.js"></script>

</body>
</html>