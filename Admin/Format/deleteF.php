<?php
// deleteG.php
// Include your database connection
include("../../DataBase.php");
// Check if the genre ID is provided
if (isset($_GET['Id'])) {


    // Get the genre ID from POST data
    $formatid = $_GET['Id'];

    // Prepare and execute the SQL statement to delete the genre
    $sql = "DELETE FROM format WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $formatid);

    if ($stmt->execute()) {
        // If deletion is successful, return success message
        header("Location:Format.php");
    } else {
        // If deletion fails, return error message
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If genre ID is not provided, return error message
    echo "Error: Format ID not provided.";
}
