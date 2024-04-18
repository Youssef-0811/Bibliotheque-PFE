<?php
// Include the database connection file
include("../../DataBase.php");

// Check if livre ID is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $livre_id = $conn->real_escape_string($_GET['id']);

    // SQL query to delete the livre with the specified ID
    $sql = "DELETE FROM livres WHERE Numero = $livre_id";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the page where livres are listed
        header("Location: Book.php");
        exit();
    } else {
        // If there was an error executing the query, display an error message
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // If livre ID is not set or empty, display an error message
    echo "Invalid livre ID.";
}

// Close the database connection
$conn->close();
