<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
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
        <h2>User Login</h2>
        <?php if (!empty($userLoginError)) echo '<div class="error-message">' . $userLoginError . '</div>'; ?>

        <form action="userLogin.php" method="post">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="submit" value="Login">
        </form>
        <button onclick="location.href='../admin/Adminlogin.php'">Admin Login</button>
        <button onclick="location.href='Register.php'">Register</button>
        <button onclick="location.href='../../accueil.php'">Back to Homepage</button>
    </div>

    <?php
    include("../../DataBase.php");
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

        // Retrieve username and password from form
        $username = sanitizeInput($_POST["username"]);
        $password = sanitizeInput($_POST["password"]);

        // Check user credentials
        $stmt = $conn->prepare("SELECT * FROM user WHERE (Nom = ? OR Email = ?)");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify password
        if ($user && password_verify($password, $user['Password'])) {
            // User login successful
            session_start();
            $_SESSION['user_id'] = $user['ID'];
            // Redirect to user dashboard or any desired page
            header("Location: ../../accueil.php");
            exit();
        } else {
            // User login failed
            $userLoginError = " Incorrecte";
        }
    }
    ?>

</body>

</html>