<?php
session_start();
$id_client = $_SESSION['ID'];
$numero = $_POST['Numero'];

include('DataBase.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $sql = "DELETE FROM emprunte_en_attente WHERE id_client = ? AND numero_livre_emprunter = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo "Error: " . $conn->error;
        exit(); // Exit if there's an error preparing the statement
    }
    
    $stmt->bind_param('ss', $id_client, $numero);
    
    if ($stmt->execute()) {
       echo "Livre supprimé de la file d'attente";
       exit(); //  exit after message to stop further execution
    } else {
       echo "Error executing statement: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Error: The form was not submitted correctly.";
}
// Close the database connection
$conn->close();
?>
