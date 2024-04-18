<?php
include("../../DataBase.php");

// Define the openEditModal function
echo "<script>
    function openEditModal(Numero, Titre, Auteur_Id, Genre_Id, Format_Id, Nbr_pages, Parution, ISBN, Resume, currentImageUrl) {
        // Set values for edit form fields
        document.getElementById('editBookId').value = Numero;
        document.getElementById('editTitre').value = Titre;
        document.getElementById('editAuteurId').value = Auteur_Id;
        document.getElementById('editGenreId').value = Genre_Id;
        document.getElementById('editFormatId').value = Format_Id;
        document.getElementById('editNbrPages').value = Nbr_pages;
        document.getElementById('editParution').value = Parution;
        document.getElementById('editISBN').value = ISBN;
        document.getElementById('editResume').value = Resume;

        // Set current image for the book
        document.getElementById('currentImage').src = currentImageUrl;

        // Display the modal
        var modal = document.getElementById('editModal');
        modal.style.display = 'block';

        // Close the modal when clicking on the close button or outside of the modal
        var span = document.getElementsByClassName('close')[0];
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
        span.onclick = function() {
            modal.style.display = 'none';
        }
    }
</script>";

// SQL query to fetch data from the "livres" table along with genre and format names
$sql = "SELECT livres.Numero, livres.Titre, livres.ISBN, livres.Parution, livres.Image, livres.ImageType, livres.Auteur_Id, 
               livres.Genre_Id, livres.Format_Id, livres.Nbr_pages, livres.Resume, auteurs.Nom AS AuteurNom, 
               genre.Nom AS GenreNom, format.Nom AS FormatNom
        FROM livres
        INNER JOIN auteurs ON livres.Auteur_Id = auteurs.Id
        LEFT JOIN genre ON livres.Genre_Id = genre.Id
        LEFT JOIN format ON livres.Format_Id = format.Id";

$result = $conn->query($sql);

// Check if the query was successful
if ($result && $result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Check if the image exists
        if ($row['Image'] !== null && $row['ImageType'] !== null) {
            // If image exists, use it
            $image = "data:" . $row['ImageType'] . ";base64," . base64_encode($row['Image']);
        } else {
            // If image is missing, use a default placeholder image
            $image = "https://via.placeholder.com/150";
        }

        echo "<tr>";
        echo "<td><img src='" . $image . "' width='100'></td>";
        echo "<td>" . $row['Titre'] . "</td>";
        echo "<td>" . $row['AuteurNom'] . "</td>";
        echo "<td>" . $row['ISBN'] . "</td>";
        echo "<td>" . $row['Parution'] . "</td>";
        echo "<td style='white-space: nowrap;'>"; // Open table data for buttons
        // Add delete button with onclick event calling showDeleteModal() function
        echo "<button class='btn btn-danger' style='margin-right: 10px' onclick='showDeleteModal(" . $row['Numero'] . ", \"" . addslashes($row['Titre']) . "\")'>Delete</button>";
        // Add edit button with onclick event calling openEditModal() function
        echo "<button class='btn btn-primary' onclick='openEditModal(\"" . $row['Numero'] . "\", \"" . $row['Titre'] . "\", \"" . $row['Auteur_Id'] . "\", \"" . $row['Genre_Id'] . "\", \"" . $row['Format_Id'] . "\", \"" . $row['Nbr_pages'] . "\", \"" . $row['Parution'] . "\", \"" . $row['ISBN'] . "\", \"" . $row['Resume'] . "\", \"" . $image . "\")'>Edit</button></td>";
        echo "</tr>";
    }
} else {
    // If no rows are returned, display a message
    echo "<tr><td colspan='7'>Aucun livre trouvé.</td></tr>";
}

// Close the database connection
$conn->close();
