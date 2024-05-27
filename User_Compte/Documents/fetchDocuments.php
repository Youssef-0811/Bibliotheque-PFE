<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display an error message
    header("Location: userLogin.php");
    exit();
}

// Include database connection file
include("../../DataBase.php");

// Retrieve user ID from session
$userID = $_SESSION['user_id'];

// Retrieve documents inserted by the logged-in user
$sql = "SELECT Id, Nom, Semestre, Filiere, Contenu, Type, Status FROM documents WHERE Id_User = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any documents
if ($result->num_rows > 0) {
    // Output table with border for the document list
    echo '<div class="overflow-y-auto max-h-96">';
    echo '<table class="w-full border-collapse border border-gray-200">';
    echo '<thead>';
    echo '<tr class="bg-gray-100 border-b border-gray-200">';
    echo '<th class="px-4 py-2 text-left">Document Title</th>';
    echo '<th class="px-4 py-2 text-left"></th>';
    echo '<th class="px-4 py-2 text-left"></th>';
    echo '<th class="px-4 py-2 text-left"></th>';
    echo '<th class="px-4 py-2 text-left"></th>';
    echo '<th class="px-4 py-2 text-left" style="padding-left: 0px;padding-right: 45px; text-align:right;">Status</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Output document cards

    while ($row = $result->fetch_assoc()) {
        $statusText = $row["Status"] == 0 ? "<span class='text-yellow-500'>Pending</span>" : "<span class='text-green-500'>Confirmed</span>";
?>
        <tr class="border-b border-gray-200">
            <td class="px-4 py-2" colspan="6">
                <div class="p-4 border rounded-lg shadow-md hover:shadow-lg mb-4 bg-white">
                    <div class="flex justify-between items-center">
                        <div class="text-lg font-semibold">
                            <a href="data:application/octet-stream;base64,<?php echo base64_encode($row["Contenu"]); ?>" download="<?php echo $row["Nom"] . $row["Type"]; ?>" class="text-blue-600 hover:underline">
                                <?php echo $row["Nom"]; ?>
                            </a>
                        </div>
                        <div class="text-sm">
                            <?php echo $statusText; ?>

                        </div>
                    </div>
                    <div class="text-sm text-gray-600 mt-2">
                        <span>Semestre: <?php echo $row["Semestre"]; ?></span> | <span>Filiere: <?php echo $row["Filiere"]; ?></span>
                    </div>
                </div>
            </td>

        </tr>
<?php

    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    // If there are more documents, display a scrollbar
    if ($result->num_rows > 3) {
        echo '<style>.max-h-96 { max-height: 24rem; }</style>';
    }
} else {
    // Output message if no documents found
    echo "<div class='document-card'>";
    echo "<div class='document-title'>Pas de documents insérés pour l'instant</div>";
    echo "</div>";
}

// Close database connection
$conn->close();
?>