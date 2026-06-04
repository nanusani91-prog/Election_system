<?php
session_start();
require('connection.php');

// If your session isn't valid, redirect to login
if(empty($_SESSION['member_id'])){
    header("Location: access-denied.php");
    exit();
}

// Retrieve voter details
$member_id = $mysqli->escape_string($_SESSION['member_id']);
$result = $mysqli->query("SELECT * FROM tbmembers WHERE member_id='$member_id'") 
    or die("Error fetching record: " . $mysqli->error);

$row = $result->fetch_assoc();
if ($row) {
    $stdId     = $row['member_id'];
    $firstName = $row['first_name'];
    $lastName  = $row['last_name'];
    $email     = $row['email'];
    $voter_id  = $row['voter_id'];
}

// Update profile
if (isset($_POST['update'])) {
    $myId        = $mysqli->escape_string($_SESSION['member_id']);
    $myFirstName = $mysqli->escape_string($_POST['firstname']);
    $myLastName  = $mysqli->escape_string($_POST['lastname']);
    $myEmail     = $mysqli->escape_string($_POST['email']);
    $myVoterid   = $mysqli->escape_string($_POST['voter_id']);
    $myPassword  = $_POST['password'];
    $confirmPass = $_POST['ConfirmPassword'];

    if ($myPassword !== $confirmPass) {
        die("<center><h3>Passwords do not match.</h3></center>");
    }

    $newpass = md5($myPassword);

    $sql = "UPDATE tbmembers SET 
                first_name='$myFirstName', 
                last_name='$myLastName', 
                email='$myEmail', 
                voter_id='$myVoterid', 
                password='$newpass' 
            WHERE member_id='$myId'";

    $mysqli->query($sql) or die("Update failed: " . $mysqli->error);

    // Redirect after update
    header("Location: manage-profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Online Voting - Manage Profile</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css">
<script src="js/user.js"></script>
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
                <li><i class="fa fa-envelope-o"></i> gruop3.rh@gmail.com</li>
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
            <li class="active"><a href="voter.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
</div>

<div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/background1.jpg');">
<section id="testimonials" class="hoc container clear">
<h2 class="font-x3 uppercase btmspace-80 underlined"> Online <a href="#">Voting</a></h2>

<ul class="nospace group">
    <li class="one_half first">
        <blockquote>
            <table border="0" width="620" align="center">
                <caption><h3>MY PROFILE</h3></caption>
                <tr><td>Id:</td><td><?php echo $stdId; ?></td></tr>
                <tr><td>First Name:</td><td><?php echo $firstName; ?></td></tr>
                <tr><td>Last Name:</td><td><?php echo $lastName; ?></td></tr>
                <tr><td>Email:</td><td><?php echo $email; ?></td></tr>
                <tr><td>Voter Id:</td><td><?php echo $voter_id; ?></td></tr>
                <tr><td>Password:</td><td>Encrypted</td></tr>
            </table>
        </blockquote>
    </li>

    <li class="one_half">
        <blockquote>
            <table border="0" width="620" align="center">
                <caption><h3>UPDATE PROFILE</h3></caption>
                <form action="manage-profile.php" method="post" onsubmit="return updateProfile(this)">
                    <tr><td>First Name:</td><td><input type="text" name="firstname" maxlength="15" value="<?php echo $firstName; ?>"></td></tr>
                    <tr><td>Last Name:</td><td><input type="text" name="lastname" maxlength="15" value="<?php echo $lastName; ?>"></td></tr>
                    <tr><td>Email:</td><td><input type="text" name="email" maxlength="100" value="<?php echo $email; ?>"></td></tr>
                    <tr><td>Voter Id:</td><td><input type="text" name="voter_id" maxlength="100" value="<?php echo $voter_id; ?>"></td></tr>
                    <tr><td>New Password:</td><td><input type="password" name="password" maxlength="15"></td></tr>
                    <tr><td>Confirm New Password:</td><td><input type="password" name="ConfirmPassword" maxlength="15"></td></tr>
                    <tr><td>&nbsp;</td><td><input type="submit" name="update" value="Update Profile"></td></tr>
                </form>
            </table>
        </blockquote>
    </li>
</ul>
</section>
</div>

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
        <p>gruop3.rh@gmail.com</p>
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
