<?php
// Include the database connection file
include("../../DataBase.php");

// Initialize an empty variable to store the result
$result = "";

$sql = "SELECT ee.id_emprunt, ee.id_client, ee.numero_livre_emprunter, ee.date_emprunt, ee.date_retour, u.Nom, u.Prenom, l.Titre
        FROM emprunte_en_attente ee
        JOIN livres l ON ee.numero_livre_emprunter = l.Numero
        JOIN user u ON ee.id_client = u.ID";



$query_result = $conn->query($sql);

// Check if the query was successful
if ($query_result) {
    // Check if there are rows returned
    if ($query_result->num_rows > 0) {
        // Loop through each row fetched from the database
        while ($row = $query_result->fetch_assoc()) {
            // Start building the table row for each entry
            $result .= "<tr>";
            $result .= "<td>" . $row["Nom"] . " " . $row["Prenom"] . "</td>";
            $result .= "<td>" . $row["Titre"] . "</td>"; // Display the Titre instead of numero_livre_emprunter
            $result .= "<td>" . $row["date_emprunt"] . "</td>";
            $result .= "<td>" . $row["date_retour"] . "</td>";

            // Add "Confirmer" button
            $result .= "<td>";
            $result .= "<button class='btn btn-danger' style='margin-right: 10px' onclick='confirmEmp(" . $row['id_emprunt'] . ", \"" . $row['id_client'] . "\" ,\"" . addslashes($row['Titre']) . "\", \"" . $row['date_emprunt'] . "\", \"" . $row['date_retour'] . "\", \"" . $row['numero_livre_emprunter'] . "\")'>confirm</button>";
            $result .= "</td>";

            // Close the table row
            $result .= "</tr>";
        }
    } else {
        // If no rows are returned, display a message
        $result = "<tr><td colspan='5'>Aucune donnée trouvée.</td></tr>";
    }
} else {
    // If the query was not successful, display an error message
    $result = "<tr><td colspan='5'>Erreur lors de l'exécution de la requête.</td></tr>";
}

// Output the result
echo $result;

// Close the database connection
