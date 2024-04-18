<?php
// Include the database connection file
include("../../DataBase.php");

// Initialize an empty variable to store the result
$result = "";

// SQL query to fetch data from the "genre" table
$sql = "SELECT * FROM emprunte_en_attente 
JOIN livres 
ON emprunte_en_attente.numero_livre_emprunter = Livres.Numero ";

$query_result = $conn->query($sql);

// Check if the query was successful
if ($query_result) {
    // Check if there are rows returned
    if ($query_result->num_rows > 0) {
        // Loop through each row fetched from the database
        while ($row = $query_result->fetch_assoc()) {
            // Start building the table row for each genre
            $result .= "<tr>";
            $result .= "<td>" . $row["id_client"] . "</td>";
            $result .= "<td>" . $row["id_emprunt"] . "</td>";
            $result .= "<td>" . $row["Titre"] . "</td>"; 
            $result .= "<td>" . $row["date_emprunt"] . "</td>";
            $result .= "<td>" . $row["date_retour"] . "</td>";
           
            // Add buttons for edit and delete actions
            $result .= "<td>";
            // Delete button with onclick event calling showDeleteModal() function
            $result .= "<button class='btn btn-danger' style='margin-right: 10px' onclick='showDeleteModal(" . $row['id_emprunt'] . ", \"" .$row['id_client'] . "\" ,\"" . addslashes($row['Titre']) . "\", \"" . $row['date_emprunt'] . "\", \"" . $row['date_retour'] . "\", \"" .$row['numero_livre_emprunter'] . "\")'>confirm</button>";
            // Edit button with onclick event calling openEditModal() function
         

            $result .= "</td>";

            // Close the table row
            $result .= "</tr>";
        }
    } else {
        // If no rows are returned, display a message
        $result = "<tr><td colspan='3'>Aucun genre trouvé.</td></tr>";
    }
} else {
    // If the query was not successful, display an error message
    $result = "<tr><td colspan='3'>Erreur lors de l'exécution de la requête.</td></tr>";
}

// Output the result
echo $result;

// Close the database connection

