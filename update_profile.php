<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $idno = $_POST['idno'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $midname = $_POST['midname'];
    $course = $_POST['course'];
    $year_level = $_POST['year_level'];

    // Check if an image was uploaded
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $target_dir = "images/";
        $image_name = basename($_FILES['profile_image']['name']);
        $target_file = $target_dir . $image_name;

        // Validate image type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        if (in_array($imageFileType, $allowed_types)) {
            // Move the uploaded file to the 'images' directory
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                // Update with image
                $stmt = $conn->prepare("UPDATE users SET idno = ?, firstname = ?, lastname = ?, midname = ?, course = ?, `Year` = ?, image = ? WHERE id = ?");
                $stmt->bind_param("sssssssi", $idno, $firstname, $lastname, $midname, $course, $year_level, $image_name, $user_id);
            } else {
                $_SESSION['error_message'] = "Error uploading the image.";
                header("Location: home.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.";
            header("Location: home.php");
            exit();
        }
    } else {
        // Update without changing the image
        $stmt = $conn->prepare("UPDATE users SET idno = ?, firstname = ?, lastname = ?, midname = ?, course = ?, `Year` = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $idno, $firstname, $lastname, $midname, $course, $year_level, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Profile updated successfully!";
    } else {
        $_SESSION['error_message'] = "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: home.php");
    exit();
}
?>
