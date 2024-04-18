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
    <style>
        /* Add your CSS styles here */
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }


        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"],
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .link-button {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form action="Adminlogin.php" method="post">
            <div class="form-group">
                <label for="admin-username">Username</label>
                <input type="text" id="admin-username" name="admin-username" required>
                <?php if (!empty($adminLoginError)) echo '<div class="error-message">' . $adminLoginError . '</div>'; ?>
            </div>
            <div class="form-group">
                <label for="admin-password">Password</label>
                <input type="password" id="admin-password" name="admin-password" required>
            </div>
            <input type="submit" value="Login">
        </form>
        <button onclick="location.href='../User/userLogin.php'">User Login</button>
        <button onclick="location.href='../User/Register.php'">Register</button>
        <button onclick="location.href='../../accueil.php'">Back to Homepage</button>
    </div>
</body>

</html>