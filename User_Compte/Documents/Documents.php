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
        Documents
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
        <a href="../Edit_Infos/UserCompte.php" class="block py-2">Edit Infos</a>
        <a href="../Books/Books.php" class="block py-2">Books</a>
        <a href="#" class="block py-2">Documents</a>
        <a href="../../accueil.php" class="block py-2">Return to Accueil</a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar md:block bg-gray-900 text-white h-screen w-64 fixed top-0 left-0 pt-24 overflow-x-hidden" style="padding-top: 40px;">
        <a href="../Edit_Infos/UserCompte.php" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/icons/boy-front-color.png" alt="Documents Image" width="30px" class="mr-2">Edit Infos
        </a>
        <a href="../Books/Books.php" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/Books/3d-render-of-stack-made-out-of-simple-blue-books.png" alt="Book Image" width="30px" class="mr-2">Books
        </a>
        <a href="#" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/Books/3d-render-of-matte-white-simple-wallet.png" alt="Documents Image" width="30px" class="mr-2">Documents
        </a>
        <a href="../../accueil.php" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/icons/Vector.png" alt="Documents Image" width="25px" class="mr-2">Return to accueil
        </a>
    </div>

    <!-- Main content area -->
    <div class="main-content ml-0 md:ml-64 p-8">
        <!-- Documents section -->
        <div id="documents">
            <h2>Document List</h2>
            <?php include("fetchDocuments.php"); ?>

            <!-- Upload form -->
            <div class="bg-white rounded-lg shadow-lg p-8 mt-8">
                <h2 class="text-2xl font-bold mb-4">Upload New Document</h2>
                <form action="Upload_Docs.php" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="nom" class="block font-semibold mb-2">Nom:</label>
                        <input type="text" id="nom" name="nom" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="semestre" class="block font-semibold mb-2">Semestre:</label>
                        <input type="text" id="semestre" name="semestre" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="filiere" class="block font-semibold mb-2">Filiere:</label>
                        <input type="text" id="filiere" name="filiere" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="file" class="block font-semibold mb-2">Select file:</label>
                        <input type="file" id="file" name="file" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <input type="submit" value="Upload Document" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg cursor-pointer transition duration-300 hover:bg-blue-600">
                </form>
            </div>
        </div>
    </div>

    <script>
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