<?php
session_start();

// Unset all of the session variables
 $_SESSION = array();

// Destroy the session.
session_destroy();

// Optional: Redirect to login page after 3 seconds
header("refresh:3;url=login.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>Online Voting - Logged Out</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- ADDED: Font Awesome CDN for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">

<!-- Top Bar -->
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
        <li><i class="fa fa-envelope-o"></i> group3@gmail.com</li>
      </ul>
    </div>
  </div>
</div>

<!-- Header -->
<div class="wrapper row1">
<header id="header" class="hoc clear">
  <div id="logo" class="fl_left">
    <h1><a href="index.php">ONLINE VOTING</a></h1>
  </div>
  <nav id="mainav" class="fl_right">
    <ul class="clear">
      <li class="active"><a href="index.php">Home</a></li>
    </ul>
  </nav>
</header>
</div>

<!-- Logged Out Message -->
<div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/wellcome.png');">
<section class="hoc container clear">
  <h2 class="font-x3 uppercase btmspace-80 underlined">Logged Out Successfully</h2>
  <div style="max-width:500px; margin:0 auto; background-color:rgba(255,255,255,0.9); padding:20px; border-radius:10px; text-align:center;">
    <p>You have been successfully logged out.</p>
    <!-- Updated text to indicate auto-redirect -->
    <p>You will be redirected to the <a href="login.php">Login</a> page in a few seconds.</p>
  </div>
</section>
</div>

<!-- Footer -->
<div class="wrapper row4">
<footer id="footer" class="hoc clear">
  <div class="one_third first">
    <h6 class="title">Address</h6>
    <p>Name: Group 3<br>University: Debre Berhan<br>Dept: IT</p>
  </div>
  <div class="one_third">
    <h6 class="title">Phone</h6>
    <p>+251916175413<br>+251916175413</p>
  </div>
  <div class="one_third">
    <h6 class="title">Email</h6>
    <p>group3@gmail.com</p>
  </div>
</footer>
</div>

<div class="wrapper row5">
<div id="copyright" class="hoc clear">
  <p class="fl_left">Copyright &copy; 2026 - All Rights Reserved - Group 3</p>
  <p class="fl_right">Template by <a target="_blank" href="http://www.os-templates.com/">OS Templates</a></p>
</div>
</div>

<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>

<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.placeholder.min.js"></script>

</body>
</html>