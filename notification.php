<?php
session_start();
include("DataBase.php");

// Check if user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo "<div class='notification-message'>Please log in to see notifications.</div>";
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
    echo "<div class='notification-message'>No Notifications</div>";
} else {
    echo "<table class='notification-table'>";
    echo "<tbody>";

    while ($notification = $result_notifications->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='notification-message'>" . htmlspecialchars($notification['message']) . "</td>";
        echo "<td><a href='mark_notification_as_read.php?notification_id=" . htmlspecialchars($notification['id']) . "' class='btn btn-sm btn-primary mark-as-read'>OK</a></td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
}

$stmt_fetch_notifications->close();
$conn->close();
