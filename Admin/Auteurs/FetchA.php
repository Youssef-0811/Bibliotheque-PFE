<?php
include("../../DataBase.php");

// Connexion à la base de données et exécution de la requête SQL
$sql = "SELECT * FROM auteurs";
$result = $conn->query($sql);

// Vérifier si la requête a réussi
if ($result && $result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr data-author-id='" . $row['Id'] . "'>"; // Add data-author-id attribute to the row
        echo "<input type='hidden' class='author-id' value='" . $row['Id'] . "'>"; // Hidden input for author ID
        echo "<td><img src='data:" . $row['ImageType'] . ";base64," . base64_encode($row['Image']) . "' style='max-width: 75px; min-width: 75px; max-height: 75px; min-height: 75px; object-fit: cover;' /></td>";
        echo "<td>" . $row['Prenom'] . "</td>";
        echo "<td>" . $row['Nom'] . "</td>";
        // Display a limited number of lines for the biography
        echo "<td><div class='biography' id='bio-" . $row['Id'] . "'>" . $row['Bio'] . "</div></td>";
        echo "<td id='dateNaissance-" . $row['Id'] . "'>" . $row['DateNaissance'] . "</td>";
        echo "<td style='white-space: nowrap;'>"; // Open table data for buttons
        // Add delete button with confirmation
        echo "<button onclick='showDeleteModal(\"" . $row['Id'] . "\", \"" . $row['Nom'] . "\")' class='btn btn-danger' style='margin-right: 10px;'>Delete</button>";
        // Add edit button with onclick event to open edit modal
        echo "<button onclick='openEditModal(\"" . $row['Id'] . "\", \"" . $row['Nom'] . "\", \"" . $row['Prenom'] . "\", \"" . $row['DateNaissance'] . "\", \"" . $row['Bio'] . "\")' class='btn btn-primary'>Edit</button>";
        echo "</td>"; // Close table data for buttons
        echo "</tr>";
    }
}

$conn->close();
