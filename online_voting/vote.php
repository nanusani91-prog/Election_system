<?php
require_once('connection.php');
session_start();

// 1. SECURITY CHECK
if(empty($_SESSION['voter_id'])){
    header("location:access-denied.php");
    exit();
}

// 2. PROCESS THE VOTE (When "Vote Now" is clicked)
if(isset($_POST['vote_now'])){
    $candidate_id = $_POST['candidate_id'];
    $voter_id = $_SESSION['voter_id'];

    // --- STEP A: Get the position of the candidate the user is trying to vote for ---
    $stmt_pos = $mysqli->prepare("SELECT candidate_position FROM tbcandidates WHERE candidate_id = ?");
    $stmt_pos->bind_param("i", $candidate_id);
    $stmt_pos->execute();
    $res_pos = $stmt_pos->get_result();
    $row_pos = $res_pos->fetch_assoc();
    $target_position = $row_pos['candidate_position'];
    $stmt_pos->close();

    // --- STEP B: Check if user has ALREADY voted for ANY candidate in this position ---
    // We join tbPolls and tbCandidates to match the voter and the position
    $check_vote = $mysqli->prepare("
        SELECT p.voter_id 
        FROM tbPolls p 
        JOIN tbcandidates c ON p.candidate_id = c.candidate_id 
        WHERE p.voter_id = ? AND c.candidate_position = ?
    ");
    $check_vote->bind_param("ss", $voter_id, $target_position);
    $check_vote->execute();
    $result_check = $check_vote->get_result();

    if($result_check->num_rows > 0){
        // ERROR: User has already voted for this POSITION
        echo "<script>alert('You have already voted for a candidate in the " . htmlspecialchars($target_position) . " position!'); window.location.href='vote.php';</script>";
    } else {
        // --- STEP C: Cast the Vote ---
        // 1. Increment Candidate Votes
        $update_votes = $mysqli->prepare("UPDATE tbcandidates SET candidate_cvotes = candidate_cvotes + 1 WHERE candidate_id = ?");
        $update_votes->bind_param("i", $candidate_id);
        
        if($update_votes->execute()){
            // 2. Log the vote in tbPolls
            $log_vote = $mysqli->prepare("INSERT INTO tbpolls (voter_id, candidate_id) VALUES (?, ?)");
            $log_vote->bind_param("si", $voter_id, $candidate_id);
            $log_vote->execute();

            echo "<script>alert('Vote successfully cast!'); window.location.href='vote.php';</script>";
        } else {
            echo "Error voting: " . $mysqli->error;
        }
    }
}

// 3. FETCH POSITIONS (For the dropdown)
 $positions = $mysqli->query("SELECT * FROM tbpositions") or die($mysqli->error);

// 4. FETCH CANDIDATES (If a position is selected)
 $candidates = [];
if(isset($_POST['Submit'])){
    $position = $_POST['position'];
    $stmt = $mysqli->prepare("SELECT * FROM tbcandidates WHERE candidate_position = ?");
    $stmt->bind_param("s", $position);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res) {
        $candidates = $res->fetch_all(MYSQLI_ASSOC); 
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Online Voting</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>

<body id="top">
<div class="wrapper row0">
  <div id="topbar" class="hoc clear"> 
    <div class="fl_left">
      <ul class="faico clear">
        <li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
      </ul>
    </div>
    <div class="fl_right">
      <ul class="nospace inline pushright">
        <li><i class="fa fa-phone"></i> +251976541234</li>
      </ul>
    </div>
  </div>
</div>

<div class="wrapper row1">
  <header id="header" class="hoc clear"> 
    <div id="logo" class="fl_left">
      <h1><a href="voter.php">ONLINE VOTING</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="vote.php">Vote</a></li>
        <li><a href="voter.php">Dashboard</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
</div>

<div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/wellcome.png');">
  <section class="hoc container clear"> 
    
    <!-- Form to Select Position -->
    <div style="background:brown; padding:20px; border-radius:5px; margin-bottom:20px;">
      <h3>Select a Position to Vote</h3>
      <form method="post">
        <label>Choose Position:</label>
        <select name="position">
          <option style="background-color:brown;" value="">Select...</option>
          <?php while($pos = $positions->fetch_assoc()) { ?>
            <option style="background-color:brown;" value="<?php echo $pos['position_name']; ?>" 
                    <?php echo (isset($_POST['position']) && $_POST['position'] == $pos['position_name']) ? 'selected' : ''; ?>>
                    <?php echo $pos['position_name']; ?>
            </option>
          <?php } ?>
        </select>
        <button type="submit" name="Submit" class="btn">Show Candidates</button>
      </form>
    </div>

    <!-- Display Candidates if position is selected -->
    <?php if(!empty($candidates)) { ?>
      <div style="background:green; padding:20px; border-radius:5px;">
        <h3>Candidates for <?php echo htmlspecialchars($_POST['position']); ?></h3>
        
        <form method="post">
          <ul class="nospace group">
            <?php foreach($candidates as $candidate) { ?>
              <li class="one_half first" style="border:1px solid #ddd; padding:10px; margin-bottom:10px; background:#f9f9f9;">
                
                <!-- Radio Button to Select Candidate -->
                <input type="radio" name="candidate_id" value="<?php echo $candidate['candidate_id']; ?>" required>
                
                <label style="font-size:18px; font-weight:bold; color:#333;">
                  <?php echo htmlspecialchars($candidate['candidate_name']); ?>
                </label>
                
                <p>Current Votes: <strong><?php echo $candidate['candidate_cvotes']; ?></strong></p>

              </li>
            <?php } ?>
          </ul>
          
          <br>
          <div style="text-align:center;">
            <!-- Submit Button for the Vote -->
            <button type="submit" name="vote_now" class="btn" style="padding:10px 20px; background:#0073aa; color:white; border:none; cursor:pointer;">
              Submit My Vote
            </button>
          </div>
        </form>
      </div>
    <?php } ?>

  </section>
</div>
</body>
</html>