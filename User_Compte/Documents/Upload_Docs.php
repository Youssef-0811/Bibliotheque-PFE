<?php
// Include database connection file
include("../../DataBase.php");

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Get data from form inputs
    $nom = $_POST["nom"];
    $semestre = $_POST["semestre"];
    $filiere = $_POST["filiere"];

    // Get id_user from session (assuming it's stored in session)
    session_start();
    $id_user = $_SESSION["user_id"]; // Assuming the session variable storing user ID is named "user_id"

    // File upload process
    $target_file = $_FILES["file"]["tmp_name"];
    $fileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

    // Determine document type based on file extension
    switch ($fileType) {
        case "pdf":
            $type = ".pdf";
            break;
        case "doc":
        case 'odt':
        case "docx":
            $type = ".docx";
            break;
        case "txt":
            $type = ".txt";
            break;
        default:
            $type = "Unknown"; // Default type if extension is not recognized
    }

    // Check file size
    if ($_FILES["file"]["size"] > 10000000) {
        echo "Sorry, your file is too large.";
    }
    if ($type == "Unknown") {
        echo "File type not recognised";
    } else {
        // Read the file content
        $content = file_get_contents($target_file);



        // Insert data into database
        $stmt = $conn->prepare("INSERT INTO documents (Id_User, Nom, Semestre, Filiere, Contenu, Type, Status) 
                                VALUES (?, ?, ?, ?, ?, ?, 0)"); // 0 is the default value for Status
        // Bind parameters
        $null = NULL;
        $stmt->bind_param("isssbs", $id_user, $nom, $semestre, $filiere, $null, $type);
        // Send binary data to MySQL
        $stmt->send_long_data(4, $content);

        if ($stmt->execute()) {
            header("Location:UserCompte.php");
        } else {
            echo "Error uploading document: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}

// Close database connection
$conn->close();
