<?php
// Include your database connection file
include("../../DataBase.php");

// Check if book_id is set and is a valid integer
if (isset($_GET['book_id']) && filter_var($_GET['book_id'], FILTER_VALIDATE_INT)) {
    // Get the book ID from the request
    $book_id = $_GET['book_id'];

    // Function to fetch review data from the database
    function fetchReviewData($book_id)
    {
        global $conn;
        $stmt_review = $conn->prepare("SELECT * FROM book_review WHERE id_book = ?");
        $stmt_review->bind_param("i", $book_id);
        $stmt_review->execute();
        $result_review = $stmt_review->get_result();
        return $result_review->fetch_assoc();
    }

    // Fetch review data for the specified book ID
    $review_data = fetchReviewData($book_id);

    // Send the review data as JSON response
    header('Content-Type: application/json');
    echo json_encode($review_data);
} else {
    // If book_id is not set or is not a valid integer, return an error response
    header("HTTP/1.1 400 Bad Request");
    echo "Invalid book ID";
}
