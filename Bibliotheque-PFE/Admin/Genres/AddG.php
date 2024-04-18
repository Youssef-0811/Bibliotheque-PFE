<?php
// Include database connection
include("../../DataBase.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $Nom = $_POST["nameGenre"];

    // Prepare SQL statement to insert data into the Genre table
    $sql = "INSERT INTO genre (Nom) VALUES (?)";

    // Prepare and bind parameter
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $Nom); // Use $Nom instead of $name

    // Execute the query
    if ($stmt->execute()) {
        header('Location: Genre.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
