<?php
// Include your database connection
include("../../DataBase.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are present in the POST data
    if (isset($_POST['document_id']) && isset($_POST['document_status'])) {
        // Sanitize the input data to prevent SQL injection
        $document_id = mysqli_real_escape_string($conn, $_POST['document_id']);
        $document_status = mysqli_real_escape_string($conn, $_POST['document_status']);

        // Update the status of the document in the database
        $query_update_status = "UPDATE documents SET Status = 1 WHERE Id = ?";
        $stmt_update_status = mysqli_prepare($conn, $query_update_status);
        mysqli_stmt_bind_param($stmt_update_status, "s", $document_id);
        $result_update_status = mysqli_stmt_execute($stmt_update_status);

        if ($result_update_status) {
            // Status updated successfully
            // Get the user ID associated with the document
            $query_get_user_id = "SELECT Id_User, Nom FROM documents WHERE Id = ?";
            $stmt_get_user_id = mysqli_prepare($conn, $query_get_user_id);
            mysqli_stmt_bind_param($stmt_get_user_id, "s", $document_id);
            mysqli_stmt_execute($stmt_get_user_id);
            $result_get_user_id = mysqli_stmt_get_result($stmt_get_user_id);

            if ($result_get_user_id && mysqli_num_rows($result_get_user_id) > 0) {
                $row = mysqli_fetch_assoc($result_get_user_id);
                $userId = $row['Id_User'];
                $documentName = $row['Nom'];

                // Insert a notification
                $message = "Your document '" . mysqli_real_escape_string($conn, $documentName) . "' has been approved.";
                $status = 0; // Status 0 indicates unread notification

                $query_insert_notification = "INSERT INTO notifications (user_id, message, created_at, Status) VALUES (?, ?, CURRENT_TIMESTAMP(), ?)";
                $stmt_insert_notification = mysqli_prepare($conn, $query_insert_notification);
                mysqli_stmt_bind_param($stmt_insert_notification, "iss", $userId, $message, $status);
                $result_insert_notification = mysqli_stmt_execute($stmt_insert_notification);

                if ($result_insert_notification) {
                    // Notification inserted successfully
                    header("Location:Documents.php");
                } else {
                    // Error inserting notification
                    echo "Error inserting notification: " . mysqli_error($conn);
                }
            } else {
                // Error retrieving user ID from the database
                echo "Error: Unable to retrieve user ID from the database";
            }
        } else {
            // Error updating status
            echo "Error updating document status: " . mysqli_error($conn);
        }
    } else {
        // Required fields are missing in the POST data
        echo "Error: Missing required fields in the POST data";
    }
} else {
    // If the request method is not POST
    echo "Error: Invalid request method";
}

// Close the database connection
mysqli_close($conn);
