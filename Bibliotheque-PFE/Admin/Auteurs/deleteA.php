<?php
// Include database connection
include("../../DataBase.php");

// Check if the author ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $author_id = $_GET['id'];

    // First, delete associated records in the livres table
    $deleteLivresQuery = "DELETE FROM livres WHERE auteur_id = $author_id";
    $resultLivres = mysqli_query($conn, $deleteLivresQuery);

    if (!$resultLivres) {
        // Handle error if deletion fails
        echo "Error deleting associated records in livres table: " . mysqli_error($conn);
    } else {
        // Proceed to delete the author record
        $deleteAuteurQuery = "DELETE FROM auteurs WHERE ID = $author_id";
        $resultAuteur = mysqli_query($conn, $deleteAuteurQuery);

        if ($resultAuteur) {
            // Author and associated records deleted successfully
            header('location: Auteur.php');
        } else {
            // Handle error if deletion fails
            echo "Error deleting author: " . mysqli_error($conn);
        }
    }
} else {
    // If author ID is not provided in the URL parameter
    echo "Author ID not provided.";
}
