<?php
// Include database connection file
include("../../DataBase.php");

// Fetch current user information
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM user WHERE ID = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentUser = $result->fetch_assoc();
} else {
    // Redirect to login page if user is not logged in
    header("Location: ../userLogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles for responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body class="font-sans bg-gray-100">
    <!-- Navbar -->
    <div class="bg-gray-900 text-white py-5 text-center text-3xl font-bold shadow" style="padding-bottom: 0px;">
        Edit Infos
    </div>
    <nav class="bg-gray-900 text-white p-4" style="
    padding-bottom: 0px;
    padding-top: 0px;
">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold"></h1>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-toggle" class="text-white focus:outline-none" style="padding-bottom: 0px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-gray-900 text-white p-4">
        <a href="#" class="block py-2">Edit Infos</a>
        <a href="../Books/Books.php" class="block py-2">Books</a>
        <a href="../Documents/Documents.php" class="block py-2">Documents</a>
        <a href="../../accueil.php" class="block py-2">Return to Accueil</a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar md:block bg-gray-900 text-white h-screen w-64 fixed top-0 left-0 pt-24 overflow-x-hidden" style="padding-top: 40px;">
        <a href="#" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/icons/boy-front-color.png" alt="Documents Image" width="30px" class="mr-2">Edit Infos
        </a>
        <a href="../Books/Books.php" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/Books/3d-render-of-stack-made-out-of-simple-blue-books.png" alt="Book Image" width="30px" class="mr-2">Books
        </a>
        <a href="../Documents/Documents.php" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/Books/3d-render-of-matte-white-simple-wallet.png" alt="Documents Image" width="30px" class="mr-2">Documents
        </a>
        <a href="../../accueil.php" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/icons/Vector.png" alt="Documents Image" width="25px" class="mr-2">Return to accueil
        </a>
    </div>

    <!-- Main content area -->
    <div class="ml-64 p-8" style="margin-left: 0px;">
        <!-- Home section -->
        <div id=" home">
            <h2>Edit Informations</h2>
            <div class="container mx-auto">
                <form action="updateUser.php" method="post" class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
                    <div class="mb-4">
                        <label for="name" class="block mb-2 font-semibold">Name</label>
                        <input type="text" id="name" name="name" value="<?= $currentUser['Nom'] ?>" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter your name">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block mb-2 font-semibold">Email</label>
                        <input type="email" id="email" name="email" value="<?= $currentUser['Email'] ?>" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter your email">
                    </div>
                    <div class="mb-4">
                        <label for="filiere" class="block mb-2 font-semibold">Filiere</label>
                        <input type="text" id="filiere" name="filiere" value="<?= $currentUser['Filiere'] ?>" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter your filiere">
                    </div>
                    <div class="mb-4 relative">
                        <label for="oldPassword" class="block mb-2 font-semibold">Old Password</label>
                        <input type="password" id="oldPassword" name="oldPassword" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter your old password">
                        <button type="button" onclick="togglePasswordVisibility('oldPassword')" class="absolute inset-y-0 right-0 px-3 py-2 bg-transparent text-gray-500 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-top: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.879 8.121a4 4 0 10-5.658 5.658 4 4 0 005.658-5.658z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.293 19.707a8 8 0 1011.414-11.414L4.293 19.707z" />
                            </svg>
                        </button>
                    </div>
                    <div class="mb-4 relative">
                        <label for="password" class="block mb-2 font-semibold">New Password</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter your new password">
                        <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 px-3 py-2 bg-transparent text-gray-500 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-top: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.879 8.121a4 4 0 10-5.658 5.658 4 4 0 005.658-5.658z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.293 19.707a8 8 0 1011.414-11.414L4.293 19.707z" />
                            </svg>
                        </button>
                    </div>
                    <div class="mb-4 relative">
                        <label for="confirmPassword" class="block mb-2 font-semibold">Confirm New Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" class="w-full px-4 py-2 border rounded-lg" placeholder="Confirm your new password">
                        <button type="button" onclick="togglePasswordVisibility('confirmPassword')" class="absolute inset-y-0 right-0 px-3 py-2 bg-transparent text-gray-500 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-top: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.879 8.121a4 4 0 10-5.658 5.658 4 4 0 005.658-5.658z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.293 19.707a8 8 0 1011.414-11.414L4.293 19.707z" />
                            </svg>
                        </button>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }

        document.getElementById("mobile-menu-toggle").addEventListener("click", function() {
            var mobileMenu = document.getElementById("mobile-menu");
            if (mobileMenu.classList.contains("hidden")) {
                mobileMenu.classList.remove("hidden");
            } else {
                mobileMenu.classList.add("hidden");
            }
        });
    </script>
</body>

</html>