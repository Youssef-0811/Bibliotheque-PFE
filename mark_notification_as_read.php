<?php
session_start(); // Start the session
include("DataBase.php"); // Include database connection

// Check if user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: ../Login/User/userLogin.php");
    exit();
}

// Check if notification_id is provided in the URL
if (isset($_GET['notification_id']) && is_numeric($_GET['notification_id'])) {
    $notification_id = intval($_GET['notification_id']); // Sanitize input

    // Update the status of the notification to 'read' (assuming 'Status' column indicates whether the notification is read)
    $sql_update_status = "UPDATE notifications SET Status = 1 WHERE id = ? AND user_id = ?";
    $stmt_update_status = $conn->prepare($sql_update_status);
    $stmt_update_status->bind_param("ii", $notification_id, $_SESSION['user_id']); // Bind parameters, including user_id to prevent unauthorized access

    if ($stmt_update_status->execute()) {
        // Status updated successfully
        header("Location: ../../accueil.php");
    } else {
        // Error updating status
        error_log("Error marking notification as read: " . $stmt_update_status->error);
        echo "Error marking notification as read.";
    }

    $stmt_update_status->close();
    $conn->close(); // Close the database connection
} else {
    // Notification ID not provided or invalid
    echo "Notification ID not provided or invalid.";
}
