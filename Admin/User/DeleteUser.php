<?php
// Include database connection file
include("../../DataBase.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if user ID is set and not empty
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Sanitize user ID
        $userId = mysqli_real_escape_string($conn, $_GET['id']);

        // Delete user from the database
        $sql = "DELETE FROM user WHERE ID=$userId";

        if (mysqli_query($conn, $sql)) {

            exit();
        } else {
            // On failure, return error message
            echo "Error deleting user: " . mysqli_error($conn);
        }
    } else {
        // If user ID is not set or empty, return error message
        echo "User ID is missing";
    }
} else {
    // If not a GET request, return error message
    echo "Invalid request method";
}
