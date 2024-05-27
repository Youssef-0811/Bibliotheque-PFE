<?php
include("../../DataBase.php");

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Query to fetch borrowed books for the specified user along with their image data and type
    $query_fetch_books = "SELECT livres.Titre, livres.Image, livres.ImageType 
                          FROM livres 
                          INNER JOIN empruntconfirme ON livres.Numero = empruntconfirme.numero_livre_emprunter 
                          WHERE empruntconfirme.id_client = $userId";

    $result_fetch_books = mysqli_query($conn, $query_fetch_books);


    $sql = "SELECT * from user where ID=$userId";
    $result_user = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result_user);
    if ($result_fetch_books && mysqli_num_rows($result_fetch_books) > 0) {
        echo "<div class='card border-left-primary shadow mb-4'>";
        echo "<div class='card-header py-3'>";
        echo "<h6 id='titleForm' class='m-0 font-weight-bold text-primary'>Les Livres Emprunter par " . $row['Nom'] . "</h6>";
        echo "</div>";
        echo "<div class='card-body2'>"; // Start of card-body2

        echo "<ul class='grid grid-cols-2 gap-4 book-list'>"; // Start of ul element

        while ($row = mysqli_fetch_assoc($result_fetch_books)) {
            echo "<li class='flex flex-col items-center'>";
            // Display the book image using base64 encoding
            echo "<img src='data:" . $row['ImageType'] . ";base64," . base64_encode($row['Image']) . "' alt='" . $row['Titre'] . "' class='w-24 h-24 object-cover rounded-lg'>";
            echo "<span class='mt-2 text-center'>" . $row['Titre'] . "</span>"; // Display book title
            echo "</li>";
        }

        echo "</ul>"; // End of ul element

        echo "</div>"; // End of card-body2
        echo "</div>"; // End of card
    } else {
        echo "No books borrowed by this user";
    }
} else {
    echo "User ID not provided";
}

mysqli_close($conn);
