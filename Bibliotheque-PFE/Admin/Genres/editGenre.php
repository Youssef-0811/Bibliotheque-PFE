<?php
// Include the database connection file
include("../../DataBase.php");

// Check if the genreId and name parameters are set
if (isset($_POST['genreId']) && isset($_POST['name'])) {
    // Escape user inputs for security
    $genreId = $conn->real_escape_string($_POST['genreId']);
    $name = $conn->real_escape_string($_POST['name']);

    // SQL query to update genre information
    $sql = "UPDATE genre SET nom='$name' WHERE Id='$genreId'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // If the update was successful, return success message
        echo "Genre updated successfully";
    } else {
        // If there was an error updating the genre, return the error message
        echo "Error updating genre: " . $conn->error;
    }
} else {
    // If genreId or name parameters are not set, return an error message
    echo "GenreId and name parameters are required";
}

// Close the database connection
$conn->close();
