<?php
include('../../DataBase.php');
// Check if all required POST parameters are set
if (isset($_POST['EMPId'], $_POST['idclient'], $_POST['dateemp'], $_POST['dateR'], $_POST['Titre'])) {
    // Sanitize user input
    $Empruntid =  $_POST['EMPId'];
    $Num =  $_POST['NumL'];
    $idclient =  $_POST['idclient'];
    $date_emprunt = $_POST['dateemp'];
    $date_retour = $_POST['dateR'];

    // Prepare and execute the SQL statement to insert into empruntconfirme table
    $sql = "INSERT INTO empruntconfirme (id_emprunt, id_client, Numero_livre_emprunter, date_emprunt, date_retour) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $Empruntid, $idclient, $Num, $date_emprunt, $date_retour);

        if ($stmt->execute()) {
            // If insertion is successful, return success message
            echo "Data inserted successfully";
            $sqlD = "DELETE FROM emprunte_en_attente WHERE id_emprunt = ?";
            $stmtD = $conn->prepare($sqlD);
            $stmtD->bind_param("s", $Empruntid);
            $stmtD->execute();

            // Insert into notifications table
            $bookTitle = $_POST['Titre'];
            $userId = $idclient;
            $message = "The book '$bookTitle' has been confirmed.";
            $status = 0; // Status 0 indicates unread notification

            $sqlN = "INSERT INTO notifications (user_id, message, created_at, Status) VALUES (?, ?, CURRENT_TIMESTAMP(), ?)";
            $stmtN = $conn->prepare($sqlN);
            $stmtN->bind_param("iss", $userId, $message, $status);
            $stmtN->execute();
        } else {
            // If insertion fails, return error message
            echo "Error: Unable to execute SQL statement.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // If statement preparation fails, return error message
        echo "Error: Unable to prepare SQL statement.";
    }
} else {
    // If required parameters are not provided, return error message
    echo "Error: Required parameters are not provided.";
}
