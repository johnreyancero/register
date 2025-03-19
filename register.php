<?php
// Start session at the top
session_start();

// Include database connection
include 'db_connect.php';

// Initialize variables
$idno = $lastname = $firstname = $midname = $course = $year_level = $username = $password = $confirm_password = "";
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $idno = trim($_POST['idno']);
    $lastname = trim($_POST['lastname']);
    $firstname = trim($_POST['firstname']);
    $midname = trim($_POST['midname']);
    $course = trim($_POST['course']);
    $year_level = $_POST['year-level'];
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm-password']);

    // Validate passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Check if username already exists
        $check_username_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check_username_stmt->bind_param("s", $username);
        $check_username_stmt->execute();
        $check_username_stmt->store_result();
        
        if ($check_username_stmt->num_rows > 0) {
            $error_message = "Username already exists. Please choose a different one.";
        } else {
            $check_username_stmt->close();

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data
            $stmt = $conn->prepare("INSERT INTO users (idno, lastname, firstname, midname, course, Year, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $idno, $lastname, $firstname, $midname, $course, $year_level, $username, $hashed_password);

            if ($stmt->execute()) {
                // Store session variables after successful registration
                $_SESSION['user_id'] = $conn->insert_id; // Store the newly registered user ID
                $_SESSION['username'] = $username;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;

                // Redirect to dashboard or welcome page
                header("Location: dashboard.php");
                exit();
            } else {
                $error_message = "Error during registration: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - My Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="auth-box2">
        
        <h1>Register</h1>

        <!-- Display error or success message -->
        <?php
            if ($error_message) {
                echo "<p style='color:red;'>$error_message</p>";
            }
        ?>

        <form action="register.php" method="post">
            <div class="input-group">
                <label for="idno">ID No:</label>
                <input type="text" id="idno" name="idno" value="<?php echo htmlspecialchars($idno); ?>" required>
            </div>

            <div class="input-group">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>
            </div>

            <div class="input-group">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required>
            </div>

            <div class="input-group">
                <label for="midname">Middle Name:</label>
                <input type="text" id="midname" name="midname" value="<?php echo htmlspecialchars($midname); ?>" required>
            </div>

            <div class="input-group">
                <label for="course">Course:</label>
                <input type="text" id="course" name="course" value="<?php echo htmlspecialchars($course); ?>" required>
            </div>

            <div class="input-group">
                <label for="year-level">Year Level:</label>
                <select id="year-level" name="year-level" required>
                    <option value="1" <?php if ($year_level == "1") echo "selected"; ?>>1st Year</option>
                    <option value="2" <?php if ($year_level == "2") echo "selected"; ?>>2nd Year</option>
                    <option value="3" <?php if ($year_level == "3") echo "selected"; ?>>3rd Year</option>
                    <option value="4" <?php if ($year_level == "4") echo "selected"; ?>>4th Year</option>
                    <option value="5" <?php if ($year_level == "5") echo "selected"; ?>>5th Year</option>
                </select>
            </div>

            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="input-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Register</button>
                <a href="login.php">Login</a>
            </div>
        </form>
    </div>

</body>
</html>
