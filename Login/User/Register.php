<?php
include("../../DataBase.php");

// Initialize error variable
$error = "";

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

    // Retrieve user registration data from form
    $nom = sanitizeInput($_POST["nom"]);
    $prenom = sanitizeInput($_POST["prenom"]);
    $email = sanitizeInput($_POST["email"]);
    $date_naissance = sanitizeInput($_POST["date_naissance"]);
    $filiere = sanitizeInput($_POST["filiere"]);
    $password = password_hash(sanitizeInput($_POST["password"]), PASSWORD_DEFAULT);

    // Check if the entered email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Email already exists, set error message
        $error = "Email already exists";
    } else {
        // Insert user data into database
        $stmt = $conn->prepare("INSERT INTO user (Nom, Prenom, Email, Date_naissance, Filiere, Password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nom, $prenom, $email, $date_naissance, $filiere, $password);
        if ($stmt->execute()) {
            // Registration successful, proceed with login
            session_start();
            $_SESSION['user_id'] = $stmt->insert_id; // Get the ID of the inserted user
            // Redirect to user dashboard or any desired page
            header("Location: ../../accueil.php");
            exit();
        } else {
            // Registration failed
            $error = "Registration failed";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow-md max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Registration</h2>
        <?php if (!empty($error)) echo '<div class="text-red-600 text-sm mb-4">' . $error . '</div>'; ?>

        <form action="Register.php" method="post">
            <div class="mb-4">
                <label for="user-nom" class="block font-semibold">Nom</label>
                <input type="text" id="user-nom" name="nom" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="user-prenom" class="block font-semibold">Prenom</label>
                <input type="text" id="user-prenom" name="prenom" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="user-email" class="block font-semibold">Email</label>
                <input type="email" id="user-email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="user-date_naissance" class="block font-semibold">Date de Naissance</label>
                <input type="date" id="user-date_naissance" name="date_naissance" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="user-filiere" class="block font-semibold">Filiere</label>
                <select name="filiere" id="user-filiere" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="" disabled selected>- - Selectionnez votre département - -</option>
                    <option value="Génie Appliqué">Genie Appliqué</option>
                    <option value="Génie Informatique">Génie Informatique</option>
                    <option value="Management">Management</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="user-password" class="block font-semibold">Password</label>
                <input type="password" id="user-password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <button type="submit" class="w-full mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg cursor-pointer hover:bg-blue-600">Register</button>
        </form>
        <p class="text-center mt-4 text-blue-500 hover:underline"><a href="userLogin.php">User Login</a></p>
        <p class="text-center mt-2 text-blue-500 hover:underline"><a href="../admin/Adminlogin.php">Admin Login</a></p>
        <p class="text-center mt-2 text-blue-500 hover:underline"><a href="../../accueil.php">Back to Homepage</a></p>
    </div>
</body>

</html>