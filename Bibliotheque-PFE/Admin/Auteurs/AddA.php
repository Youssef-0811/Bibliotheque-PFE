<?php
include("../../DataBase.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $Nom = $_POST['nom'];
    $Prenom = $_POST['prenom'];
    $DateNaissance = $_POST['date_naissance'];
    $Bio = $_POST['bio'];

    // File Upload Handling
    $imageTmp = $_FILES['image']['tmp_name'];
    $imageData = file_get_contents($imageTmp); // No need for addslashes here
    $imageType = $_FILES['image']['type'];

    // Inserting data into the database
    $stmt = $conn->prepare("INSERT INTO auteurs (Nom, Prenom, DateNaissance, Bio, Image, ImageType) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $Nom, $Prenom, $DateNaissance, $Bio, $imageData, $imageType);

    if ($stmt->execute()) {
        header('Location: Auteur.php'); // 'Location' should be capitalized
        exit; // Make sure to exit after redirection
    } else {
        echo "Erreur lors de l'insertion des données: " . $stmt->error;
    }

    $stmt->close(); // Close the prepared statement
} else {
    echo "Erreur: Le formulaire n'a pas été soumis correctement.";
}
