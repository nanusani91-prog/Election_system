<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);


require('connection.php');

session_start();
if(empty($_SESSION['voter_id'])){
    header("location:access-denied.php");
    exit();
}

// Fetch voter info
 $member_id = $_SESSION['voter_id'];
// Fix: Secure query using Prepared Statements (prevents SQL Injection)
 $stmt = $mysqli->prepare("SELECT * FROM tbmembers WHERE voter_id = ?");
 $stmt->bind_param("s", $member_id);
 $stmt->execute();
 $result_member = $stmt->get_result();
if (!$result_member) {
    die("Database Error: " . $mysqli->error);
}
if ($result_member->num_rows > 0) {
    $voter = $result_member->fetch_assoc();
} else {
    die("Voter not found in database.");
}
 $stmt->close();

// Fetch available positions
 $positions_result = $mysqli->query("SELECT * FROM tbpositions") or die("Error fetching positions: " . $mysqli->error);
?>

<!DOCTYPE html>
<html>
<head>
<title>Online Voting</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<script language="JavaScript" src="js/user.js"></script>
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
        <li><i class="fa fa-phone"></i> +251973254014</li>
        <li><i class="fa fa-envelope-o"></i> group3@gmail.com </li>
      </ul>
    </div>
  </div>
</div>

<!-- Header -->
<div class="wrapper row1">
  <header id="header" class="hoc clear"> 
    <div id="logo" class="fl_left">
      <h1><a href="voter.php">ONLINE VOTING</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="voter.php">Home</a></li>
        <li><a class="drop" href="#">Voter Pages</a>
          <ul>
            <li><a href="vote.php">Vote</a></li>
          </ul>
        </li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
</div>

<!-- Main Content -->
<div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/wellcome.png');">
  <section class="hoc container clear"> 
    <!-- FIX: Used first_name instead of username -->
    <h2 class="font-x3 uppercase btmspace-80 underlined">Welcome, <?php echo htmlspecialchars($voter['first_name'] ?? 'User'); ?>!</h2>

    <p>Below are the current positions you can vote for. Click on a position to see candidates and cast your vote.</p>

    <ul class="nospace group">
      <?php while($position = $positions_result->fetch_assoc()) { ?>
        <li class="one_half first">
          <div class="block">
            <h3><?php echo htmlspecialchars($position['position_name']); ?></h3>
            
            <!-- REMOVED: Description line because column does not exist in DB -->
            <!-- <p><?php echo htmlspecialchars($position['description']); ?></p> -->
            
            <a href="vote.php?position_id=<?php echo $position['position_id']; ?>" class="btn">Vote Now</a>
          </div>
        </li>
      <?php } ?>
    </ul>
  </section>
</div>

<!-- Footer -->
<div class="wrapper row4">
  <footer id="footer" class="hoc clear"> 
    <div class="one_third first">
      <h6 class="title">Address</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-map-marker"></i>
          <address>
            Name        : Group 3 <br>
            University  : Debre Berhan <br>
            Batch       : 3RD <br>
            Dept        : IT <br>
          </address>
        </li>
      </ul>
    </div>

    <div class="one_third">
      <h6 class="title">Phone</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-phone"></i> +251973254014<br>+251973254014</li>
      </ul>
    </div>

    <div class="one_third">
      <h6 class="title">Email</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-envelope-o"></i> group3@gmail.com </li>
      </ul>
    </div>
  </footer>
</div>

<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <p class="fl_left">Copyright &copy; 2026 - All Rights Reserved - <a href="#">Group 3</a></p>
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