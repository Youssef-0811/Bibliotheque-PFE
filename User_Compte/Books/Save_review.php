<?php
include("../../DataBase.php");

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: ../../Login/User/userLogin.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if all required parameters are set
    if (isset($_POST['book_id'], $_POST['ratingInput' . $_POST['book_id']], $_POST['reviewInput' . $_POST['book_id']])) {
        // Get the book ID, rating, and review from the POST data
        $book_id = $_POST['book_id'];
        $rating = $_POST['ratingInput' . $book_id];
        $review = $_POST['reviewInput' . $book_id];

        // Update the review in the database
        $stmt = $conn->prepare("UPDATE book_review SET rating = ?, review = ? WHERE id_client = ? AND id_book = ?");
        $stmt->bind_param("isis", $rating, $review, $user_id, $book_id);
        if ($stmt->execute()) {
            // Review updated successfully
            header("Location: Books.php");
            exit();
        } else {
            // Error occurred while updating review
            echo json_encode(array("success" => false, "error" => "An error occurred while updating the review."));
            exit();
        }
    }
} else {
    // Invalid request method
    echo json_encode(array("success" => false, "error" => "Invalid request method."));
    exit();
}
