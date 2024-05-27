<?php
include("../../DataBase.php");

// Get the user ID from the URL parameter, if present
$highlightUserId = isset($_GET['highlight_user_id']) ? $_GET['highlight_user_id'] : null;

// Query to fetch user data along with the count of books borrowed
$query_fetch_users = "SELECT user.*, COUNT(empruntconfirme.id_emprunt) AS LivresEmpruntes 
                      FROM user 
                      LEFT JOIN empruntconfirme ON user.ID = empruntconfirme.id_client 
                      GROUP BY user.ID";

$result_fetch_users = mysqli_query($conn, $query_fetch_users);

if ($result_fetch_users && mysqli_num_rows($result_fetch_users) > 0) {
    // Loop through each user and display their information
    while ($row = mysqli_fetch_assoc($result_fetch_users)) {
        // Start table row
        echo "<tr id='user_" . $row['ID'] . "'";

        // Add a special class to highlight the user if their ID matches the one retrieved
        if ($highlightUserId == $row['ID']) {
            echo " class='highlight'";
        }

        // Output user data
        echo " onclick='highlightAndScrollToUser(" . $row['ID'] . ")'>";
        echo "<td>" . $row['Nom'] . " " . $row['Prenom'] . "</td>";
        echo "<td>" . $row['Date_naissance'] . "</td>";
        echo "<td>" . $row['Filiere'] . "</td>";
        echo "<td>" . $row['LivresEmpruntes'];

        // Button to trigger fetching and displaying borrowed books
        echo "<button class='btn btn-primary' style=' margin-left: 40px;' onclick='showBorrowedBooks(" . $row['ID'] . ")'>View Books</button>";
        echo "</td>";

        // Output user data and edit/delete buttons
        echo "<td>";
        echo "<button class='btn btn-danger' onclick='openDeleteUserModal(\"" . $row['Nom'] . " " . $row['Prenom'] . "\")'>Delete</button>";
        echo "<button class='btn btn-warning' style='margin-left: 10px;' onclick='openEditUserModal(" . $row['ID'] . ", \"" . $row['Nom'] . "\", \"" . $row['Prenom'] . "\", \"" . $row['Email'] . "\", \"" . $row['Date_naissance'] . "\", \"" . $row['Filiere'] . "\")'>Edit</button>";
        echo "</td>";


        // End table row
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No users found</td></tr>";
}

mysqli_close($conn);
