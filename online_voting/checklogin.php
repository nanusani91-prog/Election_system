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
        <li><i class="fa fa-phone"></i> +251998877665</li>
        <li><i class="fa fa-envelope-o"></i> group3@gmail.com</li>
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
        <li class="active"><a href="checklogin.php">Home</a></li>
        <li><a class="drop" href="#">Voter Panel</a>
          <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="registeracc.php">Registration</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>
</div>

<div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/wellcome.png');">
  <section id="testimonials" class="hoc container clear">
    <h2 class="font-x3 uppercase btmspace-80 underlined"> Online <a href="#">Voting</a></h2>

    <ul class="nospace group">
      <li class="one_half">
        <blockquote>

        <?php
        ini_set("display_errors", "1");
        error_reporting(E_ALL);
        ob_start();
        session_start();
        require_once('connection.php');

        if (isset($_POST['myusername'], $_POST['mypassword'])) {

            $myusername = $mysqli->escape_string(trim($_POST['myusername']));
            $mypassword = $mysqli->escape_string(trim($_POST['mypassword']));
            $encrypted_mypassword = md5($mypassword);

            $sql = "SELECT * FROM tbmembers WHERE email='$myusername' AND password='$encrypted_mypassword'";
            $result = $mysqli->query($sql) or die($mysqli->error);

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                $_SESSION['voter_id'] = $user['voter_id'];
                header("Location: voter.php");
                exit();
            } else {
                echo "<h1>Invalid Credentials Provided</h1>";
                echo "Wrong Username or Password<br><br>Return to <a href='login.php'>Login</a>";
            }
        } else {
            echo "<h1>Please Login</h1>";
            echo "<form method='post' action=''>
                    <table style='background-color:powderblue;' align='center' cellpadding='5'>
                        <tr>
                            <td>Email:</td>
                            <td><input type='text' name='myusername' required></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type='password' name='mypassword' required></td>
                        </tr>
                        <tr>
                            <td colspan='2' align='center'>
                                <input type='submit' value='Login'>
                            </td>
                        </tr>
                    </table>
                  </form>";
        }

        ob_end_flush();
        ?>

        </blockquote>
      </li>
    </ul>
  </section>
</div>

<div class="wrapper row4">
  <footer id="footer" class="hoc clear">
    <div class="one_third first">
      <h6 class="title">Address</h6>
        <p>Name: Group 3<br>University: Debere Berhan<br>Dept: IT</p>
    </div>

    <div class="one_third">
      <h6 class="title">Phone</h6>
      <p>+251968891573<br>+251968891573</p>
    </div>

    <div class="one_third">
      <h6 class="title">Email</h6>
      <p>gruop3@gmail.com</p>
    </div>
  </footer>
</div>

<div class="wrapper row5">
  <div id="copyright" class="hoc clear">
  <p class="fl_left">Copyright &copy; 2026 - All Rights Reserved - Group 3</p>
  </div>
</div>

<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>

<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.placeholder.min.js"></script>

</body>
</html>
