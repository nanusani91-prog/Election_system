<!DOCTYPE html>
<html>
<body style="background-color:powderblue;">

<?php
// Start Output Buffering and Session
ob_start();
session_start();

// Enable error reporting for debugging (remove in production)
ini_set("display_errors", "1");
error_reporting(E_ALL);

// Include database connection
require('../connection.php');

 $tbl_name = "tbadministrators"; // Table name

// Check if the form was submitted
if(isset($_POST['myusername']) && isset($_POST['mypassword'])) {
    
    $myusername = $_POST['myusername'];
    $mypassword = $_POST['mypassword'];
    
    // Encrypt password using MD5 (kept for compatibility with your existing database)
    $encrypted_mypassword = md5($mypassword); 

    // Secure query using Prepared Statements to prevent SQL Injection
    $sql = "SELECT admin_id FROM $tbl_name WHERE email = ? AND password = ?";
    
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameters ("ss" means two strings)
        $stmt->bind_param("ss", $myusername, $encrypted_mypassword);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Count result rows
        $count = $result->num_rows;

        if($count == 1){
            // Fetch user data
            $user = $result->fetch_assoc();
            
            // Set Session Variables
            $_SESSION['admin_id'] = $user['admin_id'];
            $_SESSION['curname'] = $myusername;
            $_SESSION['curpass'] = $mypassword; // Plaintext password stored in session

            // Handle "Remember Me" Checkbox
            if(isset($_POST['remember'])) {
                // Set cookies (Fixed cookie names: '$email' -> 'admin_email')
                setcookie("admin_email", $myusername, time() + (30 * 24 * 60 * 60), "/"); // 30 days
                setcookie("admin_pass", $mypassword, time() + (30 * 60 * 60), "/");     // 30 days
                
                // Note: The original code did not set $_SESSION['log1'] when 'remember' was checked.
            } else {
                // Set the flag for non-remembered sessions
                $log1 = 11;
                $_SESSION['log1'] = $log1;
            }

            // Redirect to Admin Dashboard
            header("Location: admin.php");
            exit;
        } 
        else {
            // Login Failed
            echo "<br><br><br>";
            echo "<center><h3>Wrong Username or Password<br><br>Return to <a href=\"index.php\">login</a></h3></center>";
        }
        
        $stmt->close();
    } else {
        die("Database query failed.");
    }

} else {
    // Redirect if accessed directly without POST data
    header("Location: index.php");
    exit;
}

ob_end_flush();
?> 

</body>
</html>