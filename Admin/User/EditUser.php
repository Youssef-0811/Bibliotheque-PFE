<?php
// Include database connection file
include("../../DataBase.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user ID is set and not empty
    if (isset($_POST['editUserId']) && !empty($_POST['editUserId'])) {
        // Sanitize user ID
        $userId = mysqli_real_escape_string($conn, $_POST['editUserId']);

        // Sanitize and validate other form inputs
        $nom = mysqli_real_escape_string($conn, $_POST['editUserNom']);
        $prenom = mysqli_real_escape_string($conn, $_POST['editUserPrenom']);
        $email = mysqli_real_escape_string($conn, $_POST['editUserEmail']);
        $dateNaissance = mysqli_real_escape_string($conn, $_POST['editUserDateNaissance']);
        $filiere = mysqli_real_escape_string($conn, $_POST['editUserFiliere']);

        // Update user information in the database
        $sql = "UPDATE user SET Nom='$nom', Prenom='$prenom', Email='$email', Date_naissance='$dateNaissance', Filiere='$filiere' WHERE ID=$userId";

        if (mysqli_query($conn, $sql)) {
        } else {
            // On failure, return error message
            echo "Error updating user: " . mysqli_error($conn);
        }
    } else {
        // If user ID is not set or empty, return error message
        echo "User ID is missing";
    }
} else {
    // If not a POST request, return error message
    echo "Invalid request method";
}
