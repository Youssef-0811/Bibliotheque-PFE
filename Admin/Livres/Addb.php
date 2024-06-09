<?php
// Include database connection
include("../../DataBase.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = $_POST["titleBook"];
    $authorId = $_POST["authorBook"];
    $genreId = $_POST["genreBook"];
    $formatId = $_POST["formatBook"];
    $countPages = $_POST["countPageBook"];
    $releaseDate = $_POST["releaseBook"];
    $isbn = $_POST["isbnBook"];
    $resume = $_POST["resumeBook"];
    $availability = $_POST["availabilityBook"]; // New field: Disponibilité

    // Upload image
    $imageTmp = $_FILES['image']['tmp_name'];
    $imageData = file_get_contents($imageTmp);
    $imageType = $_FILES['image']['type'];

    // Prepare SQL statement to insert data into livres table
    $sql = "INSERT INTO livres (Titre, auteur_id, Genre_Id, Format_Id, Nbr_pages, Parution, ISBN, Resume, Image, ImageType, Disponible)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siisiiisssi", $title, $authorId, $genreId, $formatId, $countPages, $releaseDate, $isbn, $resume, $imageData, $imageType, $availability);

    // Execute the query
    if ($stmt->execute()) {
        // Successful insertion
        header('Location: Book.php');
        exit;
    } else {
        // Error handling
        echo "Error inserting data: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
