<?php
include("DataBase.php"); // Include database connection

// Check if user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get user ID

// Fetch unread notifications for the logged-in user
$sql_fetch_notifications = "SELECT * FROM notifications WHERE user_id = ? AND Status = 0";
$stmt_fetch_notifications = $conn->prepare($sql_fetch_notifications);
$stmt_fetch_notifications->bind_param("i", $user_id);
$stmt_fetch_notifications->execute();
$result_notifications = $stmt_fetch_notifications->get_result();

// Check if there are unread notifications
if ($result_notifications->num_rows === 0) {
    echo "<div class='notification-message'>No Notifications </div>";
} else {
    echo "<div class='notification-table-wrapper'>";
    echo "<table class='notification-table'>"; // Start table
    echo "<thead><tr><th class='table-header'>Notification</th><th class='table-header'>Action</th></tr></thead>";
    echo "<tbody>";

    // Loop through the unread notifications
    $notification_count = 0;
    while ($notification = $result_notifications->fetch_assoc()) {
        echo "<tr><td class='notification-message'>" . $notification['message'] . "</td>";
        // Add a button to mark the notification as read
        echo "<td><a href='mark_notification_as_read.php?notification_id=" . $notification['id'] . "' class='btn btn-sm btn-primary mark-as-read'>OK</a></td></tr>";
        $notification_count++;
    }

    echo "</tbody>";
    echo "</table>"; // End table

    // Add a scrollbar if there are more than three notifications
    if ($notification_count > 3) {
        echo "<style>.notification-table-wrapper { max-height: 200px; overflow-y: auto; }</style>";
    }

    echo "</div>"; // Close notification-table-wrapper
}

$stmt_fetch_notifications->close();
