<?php
include("../../DataBase.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $date_naissance = $_POST['date_naissance'];
    $filiere = $_POST['branch']; // 'branch' instead of 'filiere'
    $pass = $_POST['password'];

    // Fix your SQL query
    $sql =  "INSERT INTO user (Nom, Prenom, Email, Date_Naissance, Filiere, Password) VALUES ('$nom', '$prenom', '$email', '$date_naissance', '$filiere', '$pass')";

    if (mysqli_query($conn, $sql)) {
        header('location: ../../index.php');
        exit(); // Terminate the script after redirection
    } else {
        echo "Erreur: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Erreur: Le formulaire n'a pas été soumis correctement.";
}
