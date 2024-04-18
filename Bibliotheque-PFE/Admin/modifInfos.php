<?php
// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session
session_start();

// Include database connection
include("../DataBase.php");

// Check if admin is logged in, if not redirect to login page
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: ../Login/admin/AdminLogin.php");
    exit();
}

// Function to fetch admin information
function fetchAdminInfo($conn, $admin_id)
{
    $query = "SELECT * FROM admin WHERE Id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
}

// Check if the form is submitted for updating information or changing password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['password_change'])) {
        $old_password = $_POST["old_password"];
        $new_password = $_POST["new_password"];
        $confirm_new_password = $_POST["confirm_new_password"];

        // Fetch admin information from the database
        $admin_info = fetchAdminInfo($conn, $_SESSION['admin_id']);
        if ($admin_info) {
            // Check if the old password matches the one in the database
            $db_password = $admin_info['Password'];
            if (password_verify($old_password, $db_password)) {
                // Check if the new passwords match
                if ($new_password == $confirm_new_password) {
                    // Hash the new password
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    // Update the password in the database
                    $query = "UPDATE admin SET Password = ? WHERE Id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("si", $hashed_password, $_SESSION['admin_id']);
                    if ($stmt->execute()) {
                        header("Location: AdminDash.php?password_changed=true");
                        exit();
                    } else {
                        $password_error = "Erreur lors de la mise à jour du mot de passe.";
                    }
                    $stmt->close();
                } else {
                    $password_error = "Les nouveaux mots de passe ne correspondent pas.";
                }
            } else {
                $password_error = "Ancien mot de passe incorrect.";
            }
        } else {
            $password_error = "Impossible de récupérer les informations de l'administrateur.";
        }
    }

    // Update admin information
    if (isset($_POST['update_info'])) {
        $admin_info = fetchAdminInfo($conn, $_SESSION['admin_id']);
        if ($admin_info) {
            // Retrieve existing admin information
            $admin_lastname = $_POST["admin_lastname"] ?? $admin_info['Prenom'];
            $admin_email = $_POST["admin_email"] ?? $admin_info['Email'];
            $admin_phone = $_POST["admin_phone"] ?? $admin_info['Phone'];

            // Handle image upload
            $image_data = null;
            $image_type = null;
            if ($_FILES['admin_image']['error'] === UPLOAD_ERR_OK) {
                $image_data = file_get_contents($_FILES['admin_image']['tmp_name']);
                $image_type = $_FILES['admin_image']['type'];
            } else {
                // If no new image uploaded, use the existing one
                $image_data = $admin_info['Image'];
                $image_type = $admin_info['ImageType'];
            }

            // Update admin information in the database
            $query = "UPDATE admin SET Prenom = ?, Email = ?, Phone = ?, Image = ?, ImageType = ? WHERE Id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssi", $admin_lastname, $admin_email, $admin_phone, $image_data, $image_type, $_SESSION['admin_id']);
            if ($stmt->execute()) {
                header("Location: AdminDash.php");
                exit();
            } else {
                $info_error = "Erreur lors de la mise à jour des informations.";
            }
            $stmt->close();
        } else {
            $info_error = "Impossible de récupérer les informations de l'administrateur.";
        }
    }
}


// Fetch admin information for display
$admin_info = fetchAdminInfo($conn, $_SESSION['admin_id']);
if (!$admin_info) {
    $error = "Impossible de récupérer les informations de l'administrateur.";
}

// Close database connection
$conn->close();
