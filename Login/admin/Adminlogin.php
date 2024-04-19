<?php
session_start();
include("../../DataBase.php");

// Define variables to store errors
$adminLoginError = "";

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

    // Retrieve admin username and password from form
    $adminUsername = sanitizeInput($_POST["admin-username"]);
    $adminPassword = sanitizeInput($_POST["admin-password"]);

    // Check admin credentials
    $stmt = $conn->prepare("SELECT * FROM admin WHERE Username = ?");
    $stmt->bind_param("s", $adminUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Verify password
    if ($admin && $adminPassword === $admin['Password']) {
        // Admin login successful
        $_SESSION['admin_id'] = $admin['Id'];
        $_SESSION['admin_name'] = $admin['Nom']; // Set the admin's name in the session
        $_SESSION['admin_image_data'] = $admin['Image']; // Set the admin's image data in the session
        $_SESSION['admin_image_type'] = $admin['ImageType']; // Set the admin's image type in the session

        // Redirect to admin dashboard or any desired page
        header("Location: ../../Admin/AdminDash.php");
        exit();
    } else {
        // Admin login failed
        $adminLoginError = "Incorrect username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow-md max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Admin Login</h2>
        <form action="Adminlogin.php" method="post">
            <?php if (!empty($adminLoginError)) echo '<div class="text-red-600 text-sm mt-1">' . $adminLoginError . '</div>'; ?>

            <div class="mb-4">

                <label for="admin-username" class="block font-semibold">Username</label>
                <input type="text" id="admin-username" name="admin-username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="admin-password" class="block font-semibold">Password</label>
                <input type="password" id="admin-password" name="admin-password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <button type="submit" class="w-full mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg cursor-pointer hover:bg-blue-600">Login</button>
        </form>
        <p class="text-center mt-4 text-blue-500 hover:underline"><a href="../User/userLogin.php">User Login</a></p>
        <p class="text-center mt-2 text-blue-500 hover:underline"><a href="../User/Register.php">Register</a></p>
        <p class="text-center mt-2 text-blue-500 hover:underline"><a href="../../accueil.php">Back to Homepage</a></p>
    </div>
</body>

</html>