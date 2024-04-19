<?php
include("../../DataBase.php");
$userLoginError = "";

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

    // Retrieve username and password from form
    $username = sanitizeInput($_POST["username"]);
    $password = sanitizeInput($_POST["password"]);

    // Check user credentials
    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verify password
        if (password_verify($password, $user['Password'])) {
            // User login successful
            session_start();
            $_SESSION['user_id'] = $user['ID'];
            // Redirect to user dashboard or any desired page
            header("Location: ../../accueil.php");
            exit();
        } else {
            // Password incorrect
            $userLoginError = "Incorrect password";
        }
    } else {
        // User not found (both Nom and Email not matching)
        $userLoginError = "User not found";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow-md max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-center">User Login</h2>

        <form action="userLogin.php" method="post">
            <?php if (!empty($userLoginError)) echo '<div class="text-red-600 text-sm mt-1">' . $userLoginError . '</div>'; ?>

            <div class="mb-4">
                <label for="username" class="block font-semibold">Username or Email</label>
                <input type="text" id="username" name="username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block font-semibold">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <button type="submit" class="w-full mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg cursor-pointer hover:bg-blue-600">Login</button>
        </form>
        <p class="block mt-2 px-4 py-2 text-center"><a href="../admin/Adminlogin.php" class="text-blue-500 hover:underline">Admin Login</a></p>
        <p class="block mt-2 px-4 py-2 text-center"><a href="Register.php" class="text-blue-500 hover:underline">Register</a></p>
        <p class="block mt-2 px-4 py-2 text-center"><a href="../../accueil.php" class="text-blue-500 hover:underline">Back to Homepage</a></p>
    </div>


</body>

</html>