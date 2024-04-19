<?php
// Include database connection file
include("../../DataBase.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to sanitize input data
    function sanitizeInput($data)
    {
        global $conn;
        $data = mysqli_real_escape_string($conn, $data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Retrieve user ID from session
    session_start();
    $userID = $_SESSION['user_id'];

    // Retrieve form data and sanitize
    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $filiere = sanitizeInput($_POST["filiere"]);
    $oldPassword = sanitizeInput($_POST["oldPassword"]);
    $newPassword = sanitizeInput($_POST["password"]);
    $confirmNewPassword = sanitizeInput($_POST["confirmPassword"]);
    $dateNaissance = $_POST["dateNaissance"]; // assuming the input field is properly formatted as YYYY-MM-DD

    // Check if new password and confirm new password match
    if ($newPassword != $confirmNewPassword) {
        // Redirect with error message
        header("Location: editInfos.php?error=password_mismatch");
        exit();
    }

    // Check if the old password is correct
    $stmt = $conn->prepare("SELECT Password FROM user WHERE ID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (!password_verify($oldPassword, $row['Password'])) {
        // Redirect with error message
        header("Location: editInfos.php?error=incorrect_password");
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update user information in the database
    $updateStmt = $conn->prepare("UPDATE user SET Nom = ?, Email = ?, Filiere = ?, Password = ?, Date_naissance = ? WHERE ID = ?");
    $updateStmt->bind_param("sssssi", $name, $email, $filiere, $hashedPassword, $dateNaissance, $userID);
    if ($updateStmt->execute()) {
        // Redirect with success message
        header("Location: editInfos.php?success=updated");
        exit();
    } else {
        // Redirect with error message
        header("Location: editInfos.php?error=update_failed");
        exit();
    }
} else {
    // Redirect if accessed directly without form submission
    header("Location: editInfos.php");
    exit();
}
