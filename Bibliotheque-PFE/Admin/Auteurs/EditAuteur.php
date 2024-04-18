<?php
// Include the database connection file
include("../../DataBase.php");

// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set and not empty
    if (isset($_POST['editAuthorId']) && isset($_POST['editNom'])) {
        // Get form data and sanitize
        $authorId = $_POST['editAuthorId'];
        $nom = mysqli_real_escape_string($conn, $_POST['editNom']);
        $prenom = mysqli_real_escape_string($conn, $_POST['editPrenom']);
        $dateNaissance = mysqli_real_escape_string($conn, $_POST['editDateNaissance']);
        $bio = mysqli_real_escape_string($conn, $_POST['editBio']);

        // Initialize SQL query
        $sql = "UPDATE auteurs SET Nom='$nom', Prenom='$prenom', DateNaissance='$dateNaissance', Bio='$bio'";

        // Check if an image is uploaded
        if ($_FILES['editImage']['size'] > 0) {
            // Process the uploaded image
            $imageData = addslashes(file_get_contents($_FILES['editImage']['tmp_name']));
            $imageType = $_FILES['editImage']['type'];

            // Append image update to SQL query
            $sql .= ", Image='$imageData', ImageType='$imageType'";
        }

        // Append WHERE condition
        $sql .= " WHERE Id='$authorId'";

        // Execute the SQL query
        if ($conn->query($sql) === TRUE) {
            echo "Author updated successfully";
        } else {
            echo "Error updating author: " . $conn->error;
        }
    } else {
        echo "All fields are required";
    }
} else {
    echo "Invalid request method";
}

// Close the database connection
$conn->close();
