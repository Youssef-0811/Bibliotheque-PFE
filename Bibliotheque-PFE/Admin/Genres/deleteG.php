<?php
// deleteG.php
// Include your database connection
include("../../DataBase.php");
// Check if the genre ID is provided
if (isset($_GET['Id'])) {


    // Get the genre ID from POST data
    $genreId = $_GET['Id'];

    // Prepare and execute the SQL statement to delete the genre
    $sql = "DELETE FROM genre WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $genreId);

    if ($stmt->execute()) {
        // If deletion is successful, return success message
        header("Location:Genre.php");
    } else {
        // If deletion fails, return error message
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If genre ID is not provided, return error message
    echo "Error: Genre ID not provided.";
}
