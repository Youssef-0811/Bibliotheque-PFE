<?php
include("DataBase.php"); // Include database connection

// Check if notification_id is provided in the URL
if (isset($_GET['notification_id'])) {
    $notification_id = $_GET['notification_id'];

    // Update the status of the notification to 'read' (assuming 'Status' column indicates whether the notification is read)
    $sql_update_status = "UPDATE notifications SET Status = 1 WHERE id = ?";
    $stmt_update_status = $conn->prepare($sql_update_status);
    $stmt_update_status->bind_param("i", $notification_id);

    if ($stmt_update_status->execute()) {
        // Status updated successfully
        header("Location: ../../accueil.php");
    } else {
        // Error updating status
        echo "Error marking notification as read.";
    }

    $stmt_update_status->close();
} else {
    // Notification ID not provided
    echo "Notification ID not provided.";
}
