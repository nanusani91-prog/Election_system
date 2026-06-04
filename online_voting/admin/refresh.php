<?php
    session_start();
    require_once('../connection.php');

    //If your session isn't valid, it returns you to the login screen for protection
    if(empty($_SESSION['admin_id'])){
        header("location:access-denied.php");
        exit;
    }

    // Initialize variables to avoid "undefined variable" notices
    $candidate_name_1 = "";
    $candidate_1 = 0;
    $candidate_name_2 = "";
    $candidate_2 = 0;
    $totalvotes = 0;
    $percent_1 = 0;
    $percent_2 = 0;
    $bar_width_1 = 0;
    $bar_width_2 = 0;

    // Processing Logic
    if (isset($_POST['Submit']) && $_POST['position'] != 'select'){
        $position_name = $_POST['position'];

        // Secure query using Prepared Statements
        // We ORDER BY candidate_id to ensure Candidate 1 is always the same person
        $stmt = $mysqli->prepare("SELECT candidate_name, candidate_cvotes FROM tbcandidates WHERE candidate_position = ? ORDER BY candidate_id ASC");
        $stmt->bind_param("s", $position_name);
        $stmt->execute();
        $result = $stmt->get_result(); 

        // Fetch data for the first two candidates (Original functionality)
        $row1 = $result->fetch_assoc();
        $row2 = $result->fetch_assoc();

        if ($row1) {
            $candidate_name_1 = $row1['candidate_name'];
            $candidate_1 = (int)$row1['candidate_cvotes'];
        }

        if ($row2) {
            $candidate_name_2 = $row2['candidate_name'];
            $candidate_2 = (int)$row2['candidate_cvotes'];
        }
        $stmt->close();

        // Calculations
        $totalvotes = $candidate_1 + $candidate_2;
        
        if ($totalvotes > 0) {
            $percent_1 = round(($candidate_1 / $totalvotes) * 100, 2);
            $percent_2 = round(($candidate_2 / $totalvotes) * 100, 2);
            
            // Calculate bar width pixels (Assuming max width is around the base logic)
            // The original code used the percentage as the width pixel value directly.
            $bar_width_1 = $percent_1; 
            $bar_width_2 = $percent_2;
        }
    }

    // Retrieve positions for the dropdown
    $positions = $mysqli->query("SELECT * FROM tbpositions");
    if (!$positions) {
        die("Error fetching : " . $mysqli->error);
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>online voting</title>
<meta charset="utf-8">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<script language="JavaScript" src="js/admin.js"></script>
</head>

<body id="top">

<div class="wrapper row0">
  <div id="topbar" class="hoc clear"> 
    <div class="fl_left">
      <ul class="faico clear">
        <li><a class="faicon-facebook" href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
        <li><a class="faicon-pinterest" href="https://uk.pinterest.com/"><i class="fa fa-pinterest"></i></a></li>
        <li><a class="faicon-twitter" href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
        <li><a class="faicon-dribble" href="https://dribbble.com/"><i class="fa fa-dribbble"></i></a></li>
        <li><a class="faicon-linkedin" href="https://www.linkedin.com/"><i class="fa fa-linkedin"></i></a></li>
        <li><a class="faicon-google-plus" href="https://plus.google.com/"><i class="fa fa-google-plus"></i></a></li>
        <li><a class="faicon-rss" href="https://www.rss.com/"><i class="fa fa-rss"></i></a></li>
      </ul>
    </div>
    <div class="fl_right">
      <ul class="nospace inline pushright">
        <li><i class="fa fa-phone"></i> +251977325401</li>
        <li><i class="fa fa-envelope-o"></i> gruop3@gmail.com </li>
      </ul>
    </div>
  </div>
</div>

<div class="wrapper row1">
  <header id="header" class="hoc clear"> 
    <div id="logo" class="fl_left">
      <h1><a href="index.html">ONLINE VOTING</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="refresh.php">Home</a></li>
        <li><a class="drop" href="#">Admin Panel Pages</a>
          <ul>
            <li><a href="manage-admins.php">Manage Admin</a></li>
            <li><a href="positions.php">Manage Positions</a></li>
            <li><a href="candidates.php">Manage Candidates</a></li>
            <li><a href="refresh.php">Results</a></li>
          </ul>
        </li>
        <li><a href="http://localhost/online_voting/index.php">Voter Panel</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
</div>

<div>
  <div>
    <table width="420" align="center">
      <form name="fmNames" id="fmNames" method="post" action="refresh.php" onSubmit="return positionValidate(this)">
      <tr>
        <td style="color:#000000;">Choose Position</td>
        <td>
          <SELECT NAME="position" id="position">
            <OPTION VALUE="select">select</OPTION>
            <?php 
            // Loop through all table rows
            while ($row = $positions->fetch_assoc()){
              // Using htmlspecialchars for security
              echo "<OPTION VALUE='" . htmlspecialchars($row['position_name']) . "'>" . htmlspecialchars($row['position_name']) . "</OPTION>"; 
            }
            ?>
          </SELECT>
        </td>
        <td style="color:black;"><input type="submit" name="Submit" value="See Results" /></td>
      </tr>
      </form> 
    </table>

    <!-- Result Display Area -->
    <?php if($totalvotes > 0 || isset($_POST['Submit'])): ?>
    
      <!-- Candidate 1 -->
      <?php echo htmlspecialchars($candidate_name_1); ?>:<br>
      <img src="images/candidate-1.gif"
      width='<?php echo $bar_width_1; ?>'
      height='10'>
      <?php echo $percent_1; ?>% of <?php echo $totalvotes; ?> total votes
      <br>votes <?php echo $candidate_1; ?>
      
      <br><br>
      
      <!-- Candidate 2 -->
      <?php echo htmlspecialchars($candidate_name_2); ?>:<br>
      <img src="images/candidate-2.gif"
      width='<?php echo $bar_width_2; ?>'
      height='10'>
      <?php echo $percent_2; ?>% of <?php echo $totalvotes; ?> total votes
      <br>votes <?php echo $candidate_2; ?>

    <?php endif; ?>
  
  </div>
</div>

<div class="wrapper row4">
  <footer id="footer" class="hoc clear"> 
    <div class="one_third first">
      <h6 class="title">Address</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-map-marker"></i>
          <address>
          <p>
          Name        : Group 3 <br>
          University  : Debre Berhan <br>
          Batch       : 3RD <br>
          Dept        : IT <br>
          </p>
          </address>
        </li>
      </ul>
    </div>

    <div class="one_third">
      <h6 class="title">Phone</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-phone"></i> +251977325401<br>
          +251977325401</li>
      </ul>
    </div>

    <div class="one_third">
      <h6 class="title">Email</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-envelope-o"></i>gruop3@gmail.com </li>
      </ul>
    </div>

  </footer>
</div>

<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <p class="fl_left">Copyright &copy; 2026 - All Rights Reserved - <a href="#">Group 3</a></p>
    <p class="fl_right">Template by <a target="_blank" href="http://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
  </div>
</div>

<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>

<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<!-- IE9 Placeholder Support -->
<script src="layout/scripts/jquery.placeholder.min.js"></script>
<!-- / IE9 Placeholder Support -->
</body>
</html>