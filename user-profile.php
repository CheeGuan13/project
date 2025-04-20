<?php
session_start(); // Start the session to use session variables

if (!isset($_SESSION['username'])) { // If user is not logged in
    header("Location: login.php"); // Redirect to login page
    exit(); // Stop script execution
}

$username = $_SESSION['username']; // Retrieve username from session

include 'config.php'; // Include the database configuration

// get user information from database
$sql = "SELECT email, created_at, avatar FROM users WHERE username = '$username'"; // SQL to get user data
$result = $conn->query($sql); // Execute the query

if ($result && $row = $result->fetch_assoc()) { // Fetch the result
    $email = $row['email'];
    $created_at = $row['created_at'];
    $avatar = $row['avatar'];
} else {
    $email = null;
}

// if user not found, redirect to login
if (!$email) { // If email is empty, user doesn't exist
    unset($_SESSION['username']); // Unset the username from session
    header("Location: login.php"); // Redirect to login
    exit(); // Stop execution
}

// default avatar
$default_avatar = "images/user-icon.png"; // Set path to default avatar
$avatar = (!empty($avatar) && file_exists($avatar)) ? $avatar : $default_avatar; // Use uploaded avatar if exists, else use default

// handle delete account request
if (isset($_POST['delete_account'])) { // Check if delete account form is submitted
    $sql = "DELETE FROM users WHERE username = '$username'"; // SQL to delete user
    $conn->query($sql); // Execute deletion

    // Set success message before clearing login session
    $_SESSION['success'] = "Account deleted successfully!"; // Save success message in session
    unset($_SESSION['username']); // only clear login, not whole session

    header("Location: index.php"); // Redirect to home
    exit(); // Stop execution
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Define character encoding -->
    <title>User Profile</title> <!-- Page title -->
    <link rel="stylesheet" href="user-profile.css"> <!-- Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark px-3 fixed-top d-flex justify-content-between align-items-center">
    <div>
        <a href="user-profile.php" class="text-white text-decoration-none"><?= $username ?>'s Profile</a> <!-- Profile link -->
        <a href="index.php" class="text-white text-decoration-none ms-3">Home</a> <!-- Home link -->
        <a href="logout.php" class="text-white text-decoration-none ms-3">Logout</a> <!-- Logout link -->
    </div>
</nav>

<div class="profile-container mt-5 pt-5"> <!-- Profile container with margin and padding -->
    <img src="<?php echo $avatar; ?>" alt="Profile Picture" class="profile-img"> <!-- User's avatar -->

    <!-- Avatar Upload -->
    <form action="update-avatar.php" method="POST" enctype="multipart/form-data" onsubmit="return validateAvatarForm()" class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
        <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display: none;"> <!-- Hidden file input -->
        <button type="button" onclick="document.getElementById('avatarInput').click();" class="btn btn-primary px-4">Choose Avatar</button> <!-- Button to trigger file input -->
        <button type="submit" class="btn btn-primary px-4">Upload Avatar</button> <!-- Submit button -->
    </form>

    <div class="user-info"> <!-- User information section -->
        <h2><?= $username ?></h2> <!-- Username -->
        <p>Email: <?= $email ?></p> <!-- Email -->
        <p>Member since: <?= date("F j, Y", strtotime($created_at)) ?></p> <!-- Join date -->
    </div>

    <!-- Edit Profile -->
    <button class="edit-btn" id="editToggleBtn">Edit Profile</button> <!-- Toggle edit section -->

    <div id="editSection" style="display:none;"> <!-- Edit section hidden by default -->
        <label for="fieldSelect">Choose field to edit:</label>
        <select id="fieldSelect" onchange="showEditForm()"> <!-- Dropdown to select field -->
            <option value="">--Select--</option>
            <option value="username">Username</option>
            <option value="email">Email</option>
            <option value="password">Password</option>
        </select>

        <form id="editForm" action="update-profile.php" method="POST" style="display:none;"> <!-- Edit form -->
            <input type="hidden" name="field" id="fieldInput"> <!-- Hidden input for field name -->
            <label id="fieldLabel"></label> <!-- Label that changes based on selection -->
            <input type="text" name="new_value" id="newValue" required> <!-- Input for new value -->
            <button type="submit">Update</button> <!-- Submit button -->
        </form>
    </div>

    <!-- Delete Account -->
    <form action="" method="POST" onsubmit="return confirmDelete();"> <!-- Form to delete account -->
        <button type="submit" name="delete_account" class="btn btn-danger mt-3">🗑️ Delete Account</button> <!-- Delete button -->
    </form>
</div>

<!-- Display Alerts -->
<?php
if (isset($_SESSION['success'])) { // If success message exists
    echo "<script>alert('" . addslashes($_SESSION['success']) . "');</script>"; // Show alert
    unset($_SESSION['success']); // Clear message
}
if (isset($_SESSION['error'])) { // If error message exists
    echo "<script>alert('Error: " . addslashes($_SESSION['error']) . "');</script>"; // Show alert
    unset($_SESSION['error']); // Clear message
}
?>

<!-- Avatar Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true"> <!-- Bootstrap modal -->
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title" id="avatarModalLabel">Oops!</h5> <!-- Modal title -->
      </div>
      <div class="modal-body">Please choose an avatar before uploading.</div> <!-- Modal message -->
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button> <!-- Close modal -->
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->
<script>
    document.getElementById('editToggleBtn').addEventListener('click', function () { // Toggle edit section
        const section = document.getElementById('editSection');
        section.style.display = section.style.display === 'none' ? 'block' : 'none';
    });

    function showEditForm() { // Show corresponding form fields based on selection
        const selectedField = document.getElementById('fieldSelect').value;
        const form = document.getElementById('editForm');
        const fieldInput = document.getElementById('fieldInput');
        const fieldLabel = document.getElementById('fieldLabel');
        const newValueInput = document.getElementById('newValue');

        if (selectedField) {
            form.style.display = 'block';
            fieldInput.value = selectedField;

            if (selectedField === 'username') {
                fieldLabel.textContent = 'New Username:';
                newValueInput.type = 'text';
            } else if (selectedField === 'email') {
                fieldLabel.textContent = 'New Email:';
                newValueInput.type = 'email';
            } else if (selectedField === 'password') {
                fieldLabel.textContent = 'New Password:';
                newValueInput.type = 'password';
            }
        } else {
            form.style.display = 'none';
        }
    }

    function validateAvatarForm() { // Check if avatar file is selected
        const avatarInput = document.getElementById('avatarInput');
        if (!avatarInput.value) {
            const avatarModal = new bootstrap.Modal(document.getElementById('avatarModal'));
            avatarModal.show();
            return false;
        }
        return true;
    }

    function confirmDelete() { // Confirm before account deletion
        return confirm("Are you sure you want to delete your account? This action cannot be undone.");
    }

    // Remove URL params (like ?success=1)
    if (window.history.replaceState) {
        const url = new URL(window.location); // Get current URL
        url.search = ""; // Remove search params
        window.history.replaceState({}, document.title, url.toString()); // Replace state without reloading
    }
</script>

</body>
</html>
