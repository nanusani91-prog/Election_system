<?php
    session_start();
    require('../connection.php');

    // If your session isn't valid, it returns you to the login screen for protection
    if(empty($_SESSION['admin_id'])){
        header("location:access-denied.php");
        exit; 
    }

    // --- PROCESS ACTIONS (INSERT & DELETE) ---

    // 1. Insert New Candidate
    if (isset($_POST['Submit'])) {
        $newCandidateName = $_POST['name'];
        $newCandidatePosition = $_POST['position'];

        // Secure Insert using Prepared Statements
        $stmt = $mysqli->prepare("INSERT INTO tbcandidates(candidate_name, candidate_position) VALUES (?, ?)");
        $stmt->bind_param("ss", $newCandidateName, $newCandidatePosition);

        if ($stmt->execute()) {
            $stmt->close();
            // Redirect back to candidates to refresh the list
            header("Location: candidates.php");
            exit;
        } else {
            die("Could not insert candidate at the moment: " . $mysqli->error);
        }
    }
    // 2. Delete Candidate
    if (isset($_GET['id'])) {
        // get id value and force it to be an integer
        $id = (int)$_GET['id'];

        // Secure Delete using Prepared Statements
        $stmt = $mysqli->prepare("DELETE FROM tbcandidates WHERE candidate_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: candidates.php");
            exit;
        } else {
            die("The candidate does not exist ... " . $mysqli->error);
        }
    }

    // --- FETCH DATA FOR DISPLAY ---
    // We fetch data HERE (after processing) to ensure the list is up to date

    // Fetch candidates
    $result = $mysqli->query("SELECT * FROM tbcandidates");
    if (!$result) {
        die("There are no records to display ... \n" . $mysqli->error);
    }

    // Fetch positions for the dropdown
    $positions_retrieved = $mysqli->query("SELECT * FROM tbpositions");
    if (!$positions_retrieved) {
        die("There are no position records to display ... \n" . $mysqli->error);
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
        <li><i class="fa fa-phone"></i> +2519456732</li>
        <li><i class="fa fa-envelope-o"></i> group3@gmail.com </li>
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
        <li class="active"><a href="candidates.php">Home</a></li>
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
    <table width="380" align="center">
        <CAPTION><h3>ADD NEW CANDIDATE</h3></CAPTION>
        <form name="fmCandidates" id="fmCandidates" action="candidates.php" method="post" onsubmit="return candidateValidate(this)">
        <tr>
            <td bgcolor="#FAEBD7">Candidate Name</td>
            <td bgcolor="#FAEBD7"><input type="text" name="name" required /></td>
        </tr>
        <tr>
            <td bgcolor="#7FFFD4">Candidate Position</td>
            <td bgcolor="#7FFFD4">
                <SELECT NAME="position" id="position">
                    <OPTION VALUE="select">select</OPTION>
                    <?php
                        // Loop through all table rows
                        while ($row = $positions_retrieved->fetch_assoc()){
                            echo "<OPTION VALUE='" . htmlspecialchars($row['position_name']) . "'>" . htmlspecialchars($row['position_name']) . "</OPTION>";
                        }
                    ?>
                </SELECT>
            </td>
        </tr>
        <tr>
            <td bgcolor="#BDB76B">&nbsp;</td>
            <td bgcolor="#BDB76B"><input type="submit" name="Submit" value="Add" /></td>
        </tr>
        </form>
    </table>
    <hr>
    
    <table border="0" width="620" align="center">
        <CAPTION><h3>AVAILABLE CANDIDATES</h3></CAPTION>
        <tr>
            <th>Candidate ID</th>
            <th>Candidate Name</th>
            <th>Candidate Position</th>
            <th>Action</th>
        </tr>

        <?php
            // Loop through all table rows
            while ($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['candidate_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['candidate_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['candidate_position']) . "</td>";
                echo '<td><a href="candidates.php?id=' . $row['candidate_id'] . '">Delete Candidate</a></td>';
                echo "</tr>";
            }
            // Optional: Free result set (Clean up)
            $result->free();
            $positions_retrieved->free();
        ?>
    </table>
    <hr>
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
        <li><i class="fa fa-phone"></i> +2519456732<br>
          +2519456732</li>
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