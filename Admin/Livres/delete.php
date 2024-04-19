<?php


include("../../DataBase.php");


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve data from the form

    $s = $_POST['Numero'];
    $sql = "DELETE FROM LIVRES WHERE `Numero` = '$s'";


    if (mysqli_query($conn, $sql)) {
        header('location:Deletebook.php');
    } else {
        echo "Erreur: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Erreur: Le formulaire n'a pas été soumis correctement.";
}
