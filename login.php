<?php
// Include database connection
include 'db_connect.php';

// Initialize variables
$username = $password = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Use prepared statements to check login credentials
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password_from_db);
    $stmt->fetch();

    if ($user_id && password_verify($password, $hashed_password_from_db)) {
        // Login successful
        session_start();
        $_SESSION['user_id'] = $user_id;
        header("Location: home.php");
        exit;
    } else {
        $error_message = "Invalid username or password!";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <img src="University-of-Cebu-Logo-removebg-preview.png" alt="uclogo" class="uclogo">
    <img src="OIP-removebg-preview.png" alt="ccslogo" class="ccslogo">

    <div class="auth-box">
        <h2 class="title-font">CCS Sit in Monitoring System</h2>

        <!-- Display error message if login fails -->
        <?php
            if ($error_message) {
                echo "<p style='color:red;'>$error_message</p>";
            }
        ?>

        <form action="login.php" method="post">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Login</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="register.php">Register</a>
            </div>
        </form>
    </div>

</body>
</html>
