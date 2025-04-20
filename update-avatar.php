<?php
session_start(); // Start the session
include 'config.php'; // Include database configuration

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
    $avatar_name = $_FILES['avatar']['name'];
    $avatar_tmp = $_FILES['avatar']['tmp_name'];
    $avatar_ext = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($avatar_ext, $allowed)) {
        $new_name = "avatar_" . $username . "_" . time() . "." . $avatar_ext;
        $upload_path = "uploads/" . $new_name;

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($avatar_tmp, $upload_path)) {
            $sql = "UPDATE users SET avatar = '$upload_path' WHERE username = '$username'";
            if ($conn->query($sql)) {
                header("Location: user-profile.php?success=avatar");
                exit();
            } else {
                header("Location: user-profile.php?error=dbupdatefail");
                exit();
            }
        } else {
            header("Location: user-profile.php?error=uploadfail");
            exit();
        }
    } else {
        header("Location: user-profile.php?error=invalidfile");
        exit();
    }
} else {
    header("Location: user-profile.php?error=nofile");
    exit();
}
?>
