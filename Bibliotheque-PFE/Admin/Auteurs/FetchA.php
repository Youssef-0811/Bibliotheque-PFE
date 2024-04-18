<?php
include("../../DataBase.php");

// Connexion à la base de données et exécution de la requête SQL
$sql = "SELECT * FROM auteurs";
$result = $conn->query($sql);

// Vérifier si la requête a réussi
if ($result && $result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><img src='data:" . $row['ImageType'] . ";base64," . base64_encode($row['Image']) . "' width='100'></td>";
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

// Function to truncate the text to two lines and provide "Read More" / "See Less" link        truncate_text(          , 200) .
// function truncate_text($text)
// {
//     // Truncate the text to two lines
//     $truncated_text = '';
//     $lines = explode("\n", $text);
//     for ($i = 0; $i < 2; $i++) {
//         if (isset($lines[$i])) {
//             $truncated_text .= $lines[$i] . "<br>";
//         }
//     }

//     // Check if there are more than two lines
//     if (count($lines) > 2) {
//         // Add "Read More" link to the truncated text
//         $truncated_text .= '<a href="#" class="read-more">Read More</a>';
//     }

//     // Store the full text in a data attribute
//     $full_text = htmlspecialchars($text);
//     $truncated_text = htmlspecialchars($truncated_text);

//     // Return the truncated text with "Read More" link
//     return "<div class='biography' data-full-text='$full_text' data-truncated-text='$truncated_text'>$truncated_text</div>";
// }
// Fermer la connexion à la base de données si elle n'est plus nécessaire
$conn->close();
