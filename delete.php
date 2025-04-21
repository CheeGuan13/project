<?php
require 'config.php'; // Include database connection file

// Get the BookID from the URL (make sure the URL includes the correct BookID)
$id = $_GET['id']; 

// Check if the deletion is confirmed and proceed with deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare the SQL query to delete the book from the database
    $stmt = $conn->prepare("DELETE FROM BOOK_DETAILS WHERE BookID = ?");
    $stmt->bind_param("i", $id); // "i" stands for integer (BookID is an integer)

    if ($stmt->execute()) {
        // Display success message and redirect back to the page
        echo "<script>
                alert('Book deleted successfully!');
                window.location = 'read.php';  // Redirect to the read page after the alert
              </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!-- The Delete Confirmation Popup -->
<script>
    function confirmDelete() {
        // Display a confirmation dialog box before deletion
        if (confirm("Are you sure you want to delete this book?")) {
            document.getElementById('deleteForm').submit(); // Submit form if confirmed
        } else {
            window.location = 'read.php';  // Redirect to read.php if user cancels the action
        }
    }
</script>

<!-- The form that will be submitted on confirmation -->
<form id="deleteForm" method="POST">
    <!-- Hidden input to hold the BookID -->
    <input type="hidden" name="book_id" value="<?php echo $id; ?>">
</form>

<!-- Trigger the delete confirmation on page load -->
<script>
    confirmDelete();
</script>