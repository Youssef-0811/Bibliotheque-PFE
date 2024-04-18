<?php
$db_SERVER = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'bibliotheque1';

try {
    $conn = new mysqli($db_SERVER, $db_user, $db_pass, $db_name);

    // Check if connection is successful
    if ($conn->connect_error) {
        throw new Exception("Failed to connect to database: " . $conn->connect_error);
    }
} catch (Exception $e) {
    echo 'Failed to connect: ' . $e->getMessage();
    exit(); // Terminate script
}
