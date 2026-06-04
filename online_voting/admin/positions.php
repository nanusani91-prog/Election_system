<?php
    session_start();
    require('../connection.php');

    //If your session isn't valid, it returns you to the login screen for protection
    if( empty($_SESSION['admin_id']) ){
       header("location:access-denied.php");
       exit; 
    }

    // Inserting Position
    if (isset($_POST['Submit'])) {
        $newPosition = $_POST['position'];

        // Secure Insert using Prepared Statements
        $stmt = $mysqli->prepare("INSERT INTO tbpositions(position_name) VALUES (?)");
        $stmt->bind_param("s", $newPosition);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: positions.php");
            exit;
        } else {
            die("Could not insert position at the moment: " . $mysqli->error);
        }
    }

    // Deleting Position
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        // Secure Delete using Prepared Statements
        $stmt = $mysqli->prepare("DELETE FROM tbpositions WHERE position_id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $stmt->close();
            // redirect back to positions
            header("Location: positions.php");
            exit;
        } else {
            die("The position does not exist ... " . $mysqli->error);
        }
    }
    $result = $mysqli->query("SELECT * FROM tbpositions");

    if (!$result) {
        die("There are no records to display ... \n" . $mysqli->error);
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
        <li><i class="fa fa-phone"></i> +251977325401</li>
        <li><i class="fa fa-envelope-o"></i> group3@gmail.com </li>
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
        <li class="active"><a href="positions.php">Home</a></li>
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
        <CAPTION><h3>ADD NEW POSITION</h3></CAPTION>
        <form name="fmPositions" id="fmPositions" action="positions.php" method="post" onsubmit="return positionValidate(this)">
        <tr>
            <td bgcolor="#00ff80">Position Name</td>
            <td bgcolor="#808080"><input type="text" name="position" /></td>
            <td bgcolor="#00FF00"><input type="submit" name="Submit" value="Add" /></td>
        </tr>
        </form>
    </table>

    <table border="0" width="420" align="center">
        <CAPTION><h3>AVAILABLE POSITIONS</h3></CAPTION>
        <tr>
            <th>Position ID</th>
            <th>Position Name</th>
            <th>Action</th>
        </tr>

        <?php
            // Loop through all table rows
            while ($row = $result->fetch_assoc()){
                echo "<tr>";
                // Using htmlspecialchars to prevent XSS attacks
                echo "<td>" . htmlspecialchars($row['position_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['position_name']) . "</td>";
                echo '<td><a href="positions.php?id=' . $row['position_id'] . '">Delete Position</a></td>';
                echo "</tr>";
            }
            $result->free();
            // $mysqli->close();
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
        <li><i class="fa fa-phone"></i> +251977325401<br>
          +251977325401</li>
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