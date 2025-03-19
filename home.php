<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT idno, firstname, lastname, midname, course, Year, image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($idno, $firstname, $lastname, $midname, $course, $year_level, $profile_image);
$stmt->fetch();
$stmt->close();

// Full name for welcome message
$full_name = htmlspecialchars($firstname . " " . $lastname);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="dashboard123">
        <div class="titledashboard">
            <span class="title123">Dashboard</span>
        </div>
        <div class="box123">
            <div class="box1">
                <button class="nav-link" onclick="showContent('home')">Home</button>
                <button class="nav-link" onclick="showContent('profile-edit')">Profile</button>
                <button class="nav-link" onclick="showContent('settings')">Settings</button>
                <button class="nav-link" onclick="logout()">Logout</button>
            </div>
            <div class="box3">
                <?php if (isset($_SESSION['success_message'])): ?>
                    <p class="success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <p class="error"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></p>
                <?php endif; ?>

                <div id="home" class="content">
                    <h2>Welcome, <?php echo $full_name; ?>!</h2>
                    <img src="images/<?php echo $profile_image ? $profile_image : 'default.png'; ?>" alt="Profile Image" width="150">
                </div>

                <div id="profile-edit" class="content" style="display: none;">
                    <h2>Edit Profile</h2>
                    <form action="update_profile.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                        <div class="input-group">
                            <label for="profile_image">Change Profile Image:</label>
                            <input type="file" id="profile_image" name="profile_image" accept="image/*">
                        </div>

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
                                <option value="1" <?php if (intval($year_level) === 1) echo "selected"; ?>>1st Year</option>
                                <option value="2" <?php if (intval($year_level) === 2) echo "selected"; ?>>2nd Year</option>
                                <option value="3" <?php if (intval($year_level) === 3) echo "selected"; ?>>3rd Year</option>
                                <option value="4" <?php if (intval($year_level) === 4) echo "selected"; ?>>4th Year</option>
                                <option value="5" <?php if (intval($year_level) === 5) echo "selected"; ?>>5th Year</option>
                            </select>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="update_profile" class="btn">Save</button>
                        </div>
                    </form>
                </div>

                <div id="settings" class="content" style="display: none;">
                    <p>Settings Page (Coming Soon!)</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showContent(section) {
            document.querySelectorAll('.content').forEach(div => div.style.display = 'none');
            document.getElementById(section).style.display = 'block';
        }

        function logout() {
            if (confirm("Are you sure you want to log out?")) window.location.href = "login.php";
        }

        document.addEventListener("DOMContentLoaded", () => showContent('home'));
    </script>
</body>
</html>
