<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();
    
    // Adjust this path if your connection.php is in a different folder
    require_once("../connection.php"); 
    
    if (empty($_SESSION['admin_id'])) {
        header("location:access-denied.php");
        exit; 
    }

    // 1. Get the current file name dynamically (Fixes the 404 error)
    // This gets the filename regardless of what you named it
    $current_file = $_SERVER['PHP_SELF']; 

    // 2. PROCESS: CREATE NEW ADMINISTRATOR
    if (isset($_POST['submit'])) {
        $myFirstName = $_POST['firstname'];
        $myLastName  = $_POST['lastname'];
        $myEmail     = $_POST['email'];
        $myPassword  = $_POST['password'];

        $newpass = md5($myPassword);

        $stmt = $mysqli->prepare("INSERT INTO tbadministrators(first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $myFirstName, $myLastName, $myEmail, $newpass);

        if ($stmt->execute()) {
            $stmt->close();
            header("location: " . $current_file . "?msg=created");
            exit;
        } else {
            die("Error creating account: " . $stmt->error);
        }
    }

    // 3. PROCESS: UPDATE EXISTING ADMINISTRATOR
    if (isset($_GET['id']) && isset($_POST['update'])) {
        $myId = (int)$_GET['id'];
        $myFirstName = $_POST['firstname'];
        $myLastName  = $_POST['lastname'];
        $myEmail     = $_POST['email'];
        $myPassword  = $_POST['password'];

        $newpass = md5($myPassword);

        $stmt = $mysqli->prepare("UPDATE tbadministrators SET first_name=?, last_name=?, email=?, password=? WHERE admin_id = ?");
        $stmt->bind_param("ssssi", $myFirstName, $myLastName, $myEmail, $newpass, $myId);

        if ($stmt->execute()) {
            $stmt->close();
            // USE DYNAMIC PATH HERE
            header("location: " . $current_file . "?msg=updated");
            exit;
        } else {
            die("Error updating account: " . $stmt->error);
        }
    }

    // 4. FETCH DATA FOR LISTING
    $query = "SELECT * FROM tbadministrators";
    $result = $mysqli->query($query);

    // 5. FETCH DATA FOR EDITING
    $editMode = false;
    $editData = null;

    if (isset($_GET['edit_id'])) {
        $editId = (int)$_GET['edit_id'];
        $stmt = $mysqli->prepare("SELECT * FROM tbadministrators WHERE admin_id = ?");
        $stmt->bind_param("i", $editId);
        $stmt->execute();
        $editResult = $stmt->get_result();
        if($editResult->num_rows > 0){
            $editData = $editResult->fetch_assoc();
            $editMode = true;
        }
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Administrators</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .form-container { background: #f9f9f9; padding: 20px; margin-bottom: 20px; border: 1px solid #ccc; }
        input[type="text"], input[type="email"], input[type="password"] { padding: 5px; width: 250px; }
        input[type="submit"] { padding: 8px 15px; cursor: pointer; }
        .btn { text-decoration: none; padding: 5px 10px; color: white; border-radius: 3px;}
        .btn-edit { background-color: #ff9800; }
        .btn-delete { background-color: #f44336; }
    </style>
</head>
<body>

    <h2>Manage Administrators</h2>

    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'created') echo "<p style='color:green'>Administrator created successfully!</p>"; ?>
    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'updated') echo "<p style='color:green'>Administrator updated successfully!</p>"; ?>

    <!-- FORM -->
    <div class="form-container">
        <h3><?php echo ($editMode) ? "Edit Administrator" : "Add New Administrator"; ?></h3>
        
        <form method="post" action="<?php 
            if ($editMode) {
                echo $current_file . "?id=" . $editData['admin_id'];
            } else {
                echo $current_file;
            }
        ?>">
            
            <label>First Name:</label><br>
            <input type="text" name="firstname" required 
                   value="<?php echo ($editMode) ? htmlspecialchars($editData['first_name']) : ""; ?>"><br><br>

            <label>Last Name:</label><br>
            <input type="text" name="lastname" required 
                   value="<?php echo ($editMode) ? htmlspecialchars($editData['last_name']) : ""; ?>"><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" required 
                   value="<?php echo ($editMode) ? htmlspecialchars($editData['email']) : ""; ?>"><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" required 
                   placeholder="<?php echo ($editMode) ? "Enter new password" : "Enter password"; ?>"><br><br>

            <?php if($editMode): ?>
                <input type="submit" name="update" value="Update Admin">
                <!-- USE DYNAMIC PATH FOR CANCEL BUTTON -->
                <a href="<?php echo $current_file; ?>" style="margin-left: 10px;">Cancel</a>
            <?php else: ?>
                <input type="submit" name="submit" value="Create Admin">
            <?php endif; ?>
        </form>
    </div>

    <!-- TABLE -->
    <h3>Existing Administrators</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["admin_id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["first_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["last_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>";
                    // USE DYNAMIC PATH FOR EDIT BUTTON
                    echo "<a class='btn btn-edit' href='" . $current_file . "?edit_id=" . $row["admin_id"] . "'>Edit</a> ";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No administrators found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>