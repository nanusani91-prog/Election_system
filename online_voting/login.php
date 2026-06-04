<!DOCTYPE html>
<html>
<head>
<title>Voter Login - Online Voting</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css">
<script src="js/user.js"></script>
</head>
<body id="top">

<!-- Top Bar -->
<div class="wrapper row0"  style= "background-color: goldenrod;">
  <div id="topbar" class="hoc clear" >
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
        <li><i class="fa fa-envelope-o"></i>group3@gmail.com</li>
      </ul>
    </div>
  </div>
</div>

<!-- Header / Navigation -->
<div class="wrapper row1" >
<header id="header" class="hoc clear" style= "background-color: goldenrod;">
  <div id="logo" class="fl_left">
    <h1><a href="index.php">ONLINE VOTING</a></h1>
  </div>
  <nav id="mainav" class="fl_right">
    <ul class="clear">
      <li><a href="index.php">Home</a></li>
      <li><a href="registeracc.php">Register</a></li>
    </ul>
  </nav>
</header>
</div>

<!-- Login Section -->
<div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/wellcome.png');">
<section class="hoc container clear">
  <h2 class="font-x3 uppercase btmspace-80 underlined">Voter <a href="#">Login</a></h2>

  <div style="max-width:400px; margin:0 auto; background-color:rgba(158, 43, 43, 0.9); padding:20px; border-radius:10px;">
    <form name="form1" method="post" action="checklogin.php" onsubmit="return loginValidate(this)">
      <div style="margin-bottom:15px;">
        <label for="myusername" style="display:block; color:blue;">Email</label>
        <input type="text" name="myusername" id="myusername" style="width:100%; padding:8px; color:brown;">
      </div>
      <div style="margin-bottom:15px;">
        <label for="mypassword" style="display:block; color:blue;">Password</label>
        <input type="password" name="mypassword" id="mypassword" style="width:100%; padding:8px; color:brown;">
      </div>
      <div style="text-align:center;">
        <input type="submit" name="Submit" value="Login" style="padding:10px 20px; background-color:#007BFF; color:#fff; border:none; cursor:pointer;">
      </div>
    </form>
    <p style="text-align:center; margin-top:15px; color:#007BFF;">Not yet registered? <a href="registeracc.php"><b>Register Here</b></a></p>
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
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.placeholder.min.js"></script>

</body>
</html>
