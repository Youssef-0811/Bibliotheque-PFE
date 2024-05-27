<?php
// Include your database connection
include("../../DataBase.php");

// Query to fetch documents with status = 0 along with the user's name who added them
$query_fetch_documents = "SELECT documents.*, user.Nom AS AddedByNom, user.Prenom AS AddedByPrenom FROM documents INNER JOIN user ON documents.Id_User = user.Id WHERE documents.Status = 0";

$result_fetch_documents = mysqli_query($conn, $query_fetch_documents);

if ($result_fetch_documents && mysqli_num_rows($result_fetch_documents) > 0) {
    while ($row = mysqli_fetch_assoc($result_fetch_documents)) {
        // Display each document row in the table
        echo "<tr>";
        echo "<td>";
        // Download link for the document
        echo "<a href='data:application/octet-stream;base64," . base64_encode($row["Contenu"]) . "' download='" . $row["Nom"] . $row["Type"] . "' class='text-blue-600 hover:underline'>" . $row["Nom"] . "</a>";
        echo "</td>";
        echo "<td><a href='../User/User.php?id=" . $row['Id_User'] . "'>" . $row['AddedByNom'] . " " . $row['AddedByPrenom'] . "</a></td>";
        echo "<td>" . $row['Semestre'] . "</td>";
        echo "<td>" . $row['Filiere'] . "</td>";
        echo "<td>";
        // Confirm button with onclick event to trigger JavaScript function and pass document details
        echo "<button class='btn btn-primary confirm-btn' onclick='openConfirmationModal(" . $row['Id'] . ", \"" . $row['Nom'] . "\", " . $row['Status'] . ")'>Confirm</button>";
        echo "</td>";

        echo "</tr>";
    }
} else {
    // If no documents found, display a message
    echo "<tr><td colspan='5'>No documents found</td></tr>";
}

// Close the database connection
mysqli_close($conn);
