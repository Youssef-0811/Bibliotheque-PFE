<?php
// Include the database connection file
include("../../DataBase.php");

// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set and not empty
    if (isset($_POST['editBookId']) && isset($_POST['editTitre']) && isset($_POST['editAuteurId']) && isset($_POST['editGenreId']) && isset($_POST['editFormatId']) && isset($_POST['editNbrPages']) && isset($_POST['editParution']) && isset($_POST['editISBN']) && isset($_POST['editResume']) && isset($_POST['editDisponibilite'])) {
        // Get form data and sanitize
        $bookId = $_POST['editBookId'];
        $titre = mysqli_real_escape_string($conn, $_POST['editTitre']);
        $auteurId = $_POST['editAuteurId'];
        $genreId = $_POST['editGenreId'];
        $formatId = $_POST['editFormatId'];
        $nbrPages = $_POST['editNbrPages'];
        $parution = $_POST['editParution'];
        $isbn = $_POST['editISBN'];
        $resume = mysqli_real_escape_string($conn, $_POST['editResume']);
        $disponibilite = $_POST['editDisponibilite'];

        // Check if an image is uploaded
        if ($_FILES['editImage']['size'] > 0) {
            // Process the uploaded image
            $imageData = addslashes(file_get_contents($_FILES['editImage']['tmp_name']));
            $imageType = $_FILES['editImage']['type'];

            // Perform update operation with image and disponibilité
            $sql = "UPDATE livres SET Titre='$titre', Auteur_Id='$auteurId', Genre_Id='$genreId', Format_Id='$formatId', Nbr_pages='$nbrPages', Parution='$parution', ISBN='$isbn', Resume='$resume', Image='$imageData', ImageType='$imageType', Disponible='$disponibilite' WHERE Numero='$bookId'";
        } else {
            // Perform update operation without image and with disponibilité
            $sql = "UPDATE livres SET Titre='$titre', Auteur_Id='$auteurId', Genre_Id='$genreId', Format_Id='$formatId', Nbr_pages='$nbrPages', Parution='$parution', ISBN='$isbn', Resume='$resume', Disponible='$disponibilite' WHERE Numero='$bookId'";
        }

        // Execute the SQL query
        if ($conn->query($sql) === TRUE) {
            header('location:./Book.php');
        } else {
            echo "Error updating book: " . $conn->error;
        }
    } else {
        echo "All fields are required";
    }
} else {
    echo "Invalid request method";
}

// Close the database connection
$conn->close();
