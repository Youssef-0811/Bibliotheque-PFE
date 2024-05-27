<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or display an error message
    header("Location: ../../Login/User/userLogin.php");
    exit(); // Stop further execution
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data (you can add more validation if needed)
    $userId = $_SESSION['user_id']; // Get user ID from session
    $bookId = $_POST['book_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Include database connection file
    include("../../DataBase.php");

    // Prepare and execute SQL query to insert review data into the book_review table
    $sql = "INSERT INTO book_review (id_client, id_book, rating, review) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $userId, $bookId, $rating, $review);

    if ($stmt->execute()) {
        // Review inserted successfully
        header("Location:Books.php");
    } else {
        // Error occurred
        echo "Error: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect back to the previous page or display an error message
    echo "Form submission error!";
}
