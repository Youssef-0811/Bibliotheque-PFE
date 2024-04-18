<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Compte</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="font-sans bg-gray-100">
    <!-- Header -->
    <div class="bg-gray-900 text-white py-5 text-center text-3xl font-bold shadow">
        User Compte
    </div>

    <!-- Sidebar -->
    <div class="bg-gray-900 text-white h-screen w-64 fixed top-0 left-0 pt-24 overflow-x-hidden" style=" padding-top: 40px;">
        <a href="Documents.php" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../images/icons/boy-front-color.png" alt="Documents Image" width="30px" class="mr-2">Edit Infos
        </a>
        <a href="#books" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../images/Books/3d-render-of-stack-made-out-of-simple-blue-books.png" alt="Book Image" width="30px" class="mr-2">Books
        </a>
        <a href="Documents.php" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../images/Books/3d-render-of-matte-white-simple-wallet.png" alt="Documents Image" width="30px" class="mr-2">Documents
        </a>
    </div>

    <!-- Main content area -->
    <div class="ml-64 p-8">
        <!-- Home section -->
        <div id="home">
            <h2>Home</h2>
            <!-- Display user info and borrowed books -->
            <!-- Replace this with your PHP code to display user info and borrowed books -->
        </div>

        <!-- Books section -->
        <div id="books" style="display: none;">
            <h2>Books</h2>
            <!-- Display borrowed books and allow adding review -->
            <!-- Replace this with your PHP code to display borrowed books and add review -->
        </div>

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

    <!-- Return to Accueil button -->
    <button class="fixed bottom-8 left-8 bg-blue-500 text-white px-4 py-2 rounded-lg cursor-pointer transition duration-300 hover:bg-blue-600" onclick="window.location.href = '../accueil.php';">Return to Accueil</button>
</body>

</html>