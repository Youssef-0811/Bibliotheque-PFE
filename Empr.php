<?php
session_start();
include('DataBase.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve data from the form
    $id_client = $_SESSION['user_id'];
    $numero = $_POST['numerodelivre'];
    $date_emprunt = $_POST['departureDate'];
    $date_retour = $_POST['returnDate'];

    // Prepare SQL statement to check if the book is already borrowed by the client
    $stmt = $conn->prepare("SELECT COUNT(*) FROM emprunte_en_attente WHERE numero_livre_emprunter = ? AND id_client = ?");
    $stmt->bind_param('ss', $numero, $id_client);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    // Check if the value exists
    if ($count > 0) {
        $message = 'vous avez emprunter ce livre Attender la confirmation de l`emprunt';
        echo '<script type="text/javascript">window.alert("' . $message . '");</script>';
    } else {
        $stmt->close();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM empruntconfirme WHERE numero_livre_emprunter = ? AND id_client = ?");
        $stmt->bind_param('ss', $numero, $id_client);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        if ($count > 0) {
            $message = 'vous avez deja emprunter ce livre';
            echo '<script type="text/javascript">window.alert("' . $message . '");</script>';
        } else {
            $stmt->close();

            // Insert data into the "emprunte_en_attente" table
            $sql = "INSERT INTO emprunte_en_attente (id_client, numero_livre_emprunter, date_emprunt, date_retour) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $id_client, $numero, $date_emprunt, $date_retour);
            if ($stmt->execute()) {
                // Fetch the ID of the newly created emprunt
                $emprunt_id = $conn->insert_id;

                // Prepare and insert the notification
                $notification_message = "Pour confirmer votre emprunt donnez ce code a votre Bibliothéquere: $emprunt_id";
                $notification_sql = "INSERT INTO notifications (user_id, message, Status) VALUES (?, ?, 0)";
                $notification_stmt = $conn->prepare($notification_sql);
                $notification_stmt->bind_param('is', $id_client, $notification_message);
                $notification_stmt->execute();
                $notification_stmt->close();

                // Redirect to index.php
                header('Location: index.php');
                exit(); // Added exit after header to stop further execution
            } else {
                echo "Error: " . $sql . "<br>" . $stmt->error; // Corrected to use $stmt->error
            }
        }
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Error: The form was not submitted correctly.";
}
