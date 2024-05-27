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

// Function to fetch book information
function getBookInfo($book_id)
{
    global $conn;
    $stmt_book = $conn->prepare("SELECT * FROM livres WHERE Numero = ?");
    $stmt_book->bind_param("i", $book_id);
    $stmt_book->execute();
    $result_book = $stmt_book->get_result();
    return $result_book->fetch_assoc();
}

// Function to check if the user has already reviewed a book
function hasReviewedBook($user_id, $book_id)
{
    global $conn;
    $stmt_review = $conn->prepare("SELECT * FROM book_review WHERE id_client = ? AND id_book = ?");
    $stmt_review->bind_param("ii", $user_id, $book_id);
    $stmt_review->execute();
    $result_review = $stmt_review->get_result();
    return $result_review->num_rows > 0;
}

// Initialize hasReviewed outside the loop
$hasReviewed = false;

// Query pending borrowings
$stmt_pending = $conn->prepare("SELECT * FROM emprunte_en_attente WHERE id_client = ?");
$stmt_pending->bind_param("i", $user_id);
$stmt_pending->execute();
$result_pending = $stmt_pending->get_result();

// Query confirmed borrowings
$stmt_confirmed = $conn->prepare("SELECT * FROM empruntconfirme WHERE id_client = ?");
$stmt_confirmed->bind_param("i", $user_id);
$stmt_confirmed->execute();
$result_confirmed = $stmt_confirmed->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles for responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Star colors */
        .star-yellow {
            color: #FBBF24;
            /* Yellow color */
        }

        .star-black {
            color: #000000;
            /* Black color */
        }

        /* Style for the star icons */
        .star {
            font-size: 24px;
            /* Adjust the size of the stars as needed */
            cursor: pointer;
        }

        .review-container {
            display: flex;
            align-items: flex-start;
        }

        .stars-container {
            margin-bottom: 10px;
            /* Adjust as needed */
        }

        .review-actions {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .edit-button button {
            align-self: flex-start;
        }
    </style>
</head>

<body class="font-sans bg-gray-100">
    <!-- Navbar -->
    <div class="bg-gray-900 text-white py-5 text-center text-3xl font-bold shadow" style="padding-bottom: 0px;">
        Books
    </div>
    <nav class="bg-gray-900 text-white p-4" style="padding-bottom: 0px;padding-top: 0px;">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold"></h1>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-toggle" class="text-white focus:outline-none" style="padding-bottom: 0px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-gray-900 text-white p-4">
        <a href="../Edit_Infos/UserCompte.php" class="block py-2">Edit Infos</a>
        <a href="#" class="block py-2">Books</a>
        <a href="../Documents/Documents.php" class="block py-2">Documents</a>
        <a href="../../accueil.php" class="block py-2">Return to Accueil</a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar md:block bg-gray-900 text-white h-screen w-64 fixed top-0 left-0 pt-24 overflow-x-hidden" style="padding-top: 40px;">
        <a href="../Edit_Infos/UserCompte.php" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/icons/boy-front-color.png" alt="Documents Image" width="30px" class="mr-2">Edit Infos
        </a>
        <a href="#" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/Books/3d-render-of-stack-made-out-of-simple-blue-books.png" alt="Book Image" width="30px" class="mr-2">Books
        </a>
        <a href="../Documents/Documents.php" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/Books/3d-render-of-matte-white-simple-wallet.png" alt="Documents Image" width="30px" class="mr-2">Documents
        </a>
        <a href="../../accueil.php" class="block py-3 px-4 hover:bg-gray-700 flex items-center">
            <img src="../../images/icons/Vector.png" alt="Documents Image" width="25px" class="mr-2">Return to accueil
        </a>
    </div>


    <!-- Main content area -->
    <div id="main-content" class="ml-0 md:ml-64 p-8">

        <!-- Books section -->
        <div id="books" style="display: none;">
            <h2>Books</h2>
            <!-- Display borrowed books and allow adding review -->
            <!-- Replace this with your PHP code to display borrowed books and add review -->
        </div>
        <!-- Display pending borrowings -->
        <div>
            <h2 class="pending-title text-2xl font-bold mb-4">Pending Borrowings</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="px-4 py-2" style="width: 33.33%;">Book Name</th>
                            <th class="px-4 py-2" style="width: 33.33%;">Date Borrowed</th>
                            <th class="px-4 py-2" style="width: 33.33%;">Date Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Fetch and display pending borrowings dynamically -->
                        <?php while ($row = $result_pending->fetch_assoc()) : ?>
                            <?php $book_info = getBookInfo($row['numero_livre_emprunter']); ?>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2" style="width: 33.33%;">
                                    <img src="data:image/<?php echo $book_info['ImageType']; ?>;base64,<?php echo base64_encode($book_info['Image']); ?>" alt="<?php echo $book_info['Titre']; ?>" class="w-12 h-12 object-cover rounded-full">
                                    <span class="ml-2"><?php echo $book_info['Titre']; ?></span>
                                </td>
                                <td class="px-4 py-2" style="width: 33.33%;"><?php echo $row['date_emprunt']; ?></td>
                                <td class="px-4 py-2" style="width: 33.33%;"><?php echo $row['date_retour']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Display confirmed borrowings -->
        <div class="mt-8">
            <h2 class="confirmed-title text-2xl font-bold mb-4">Confirmed Borrowings</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="px-4 py-2 text-left" style="width: 25%;">Book Name</th>
                            <th class="px-4 py-2 text-left" style="width: 25%;">Date Borrowed</th>
                            <th class="px-4 py-2 text-left" style="width: 25%;">Date Due</th>
                            <th class="px-4 py-2 text-left" style="width: 25%; ">Reviews</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Fetch and display confirmed borrowings dynamically -->
                        <?php while ($row = $result_confirmed->fetch_assoc()) : ?>
                            <?php $book_info = getBookInfo($row['numero_livre_emprunter']); ?>
                            <?php $hasReviewed = hasReviewedBook($user_id, $book_info['Numero']); ?>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2 text-left w-1/4">
                                    <img src="data:image/<?php echo $book_info['ImageType']; ?>;base64,<?php echo base64_encode($book_info['Image']); ?>" alt="<?php echo $book_info['Titre']; ?>" class="w-12 h-12 object-cover rounded-full">
                                    <span class="ml-2"><?php echo $book_info['Titre']; ?></span>
                                </td>
                                <td class="px-4 py-2 text-left w-1/4"><?php echo $row['date_emprunt']; ?></td>
                                <td class="px-4 py-2 text-left w-1/4"><?php echo $row['date_retour']; ?></td>
                                <td class="px-4 py-2 text-left w-1/4">
                                    <?php if ($hasReviewed) : ?>
                                        <!-- Display existing review with edit option -->
                                        <div id="reviewContainer<?php echo $book_info['Numero']; ?>" class="review-container flex items-center">
                                            <div class="stars-container flex mr-4">
                                                <?php
                                                $stmt_rating = $conn->prepare("SELECT rating FROM book_review WHERE id_client = ? AND id_book = ?");
                                                $stmt_rating->bind_param("ii", $user_id, $book_info['Numero']);
                                                $stmt_rating->execute();
                                                $result_rating = $stmt_rating->get_result();
                                                $row_rating = $result_rating->fetch_assoc();

                                                $rating = isset($row_rating['rating']) ? intval($row_rating['rating']) : 0;
                                                for ($i = 1; $i <= 5; $i++) : ?>
                                                    <?php if ($i <= $rating) : ?>
                                                        <span class="star-yellow text-xl">&#9733;</span>
                                                    <?php else : ?>
                                                        <span class="star-black text-xl">&#9733;</span>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                            <div class="review-actions flex-grow">
                                                <?php
                                                $stmt_review = $conn->prepare("SELECT review FROM book_review WHERE id_client = ? AND id_book = ?");
                                                $stmt_review->bind_param("ii", $user_id, $book_info['Numero']);
                                                $stmt_review->execute();
                                                $result_review = $stmt_review->get_result();
                                                $row_review = $result_review->fetch_assoc();
                                                ?>
                                                <?php if (isset($row_review['review'])) : ?>
                                                    <div id="reviewField<?php echo $book_info['Numero']; ?>">
                                                        <?php
                                                        $review_text = $row_review['review'];
                                                        $shortened_review = substr($review_text, 0, 10);
                                                        ?>
                                                        <p class="text-gray-800" id="shortReview<?php echo $book_info['Numero']; ?>"><?php echo $shortened_review; ?>
                                                            <?php if (strlen($review_text) > 10) : ?>
                                                                <a href="#" class="text-blue-500 hover:underline" onclick="showFullReview(<?php echo $book_info['Numero']; ?>)">Read More</a>
                                                            <?php endif; ?>
                                                        </p>
                                                        <textarea id="fullReview<?php echo $book_info['Numero']; ?>" class="hidden" readonly><?php echo $review_text; ?></textarea>
                                                        <a href="#" class="text-blue-500 hover:underline hidden" id="hideReview<?php echo $book_info['Numero']; ?>" onclick="hideFullReview(<?php echo $book_info['Numero']; ?>)">Hide</a>
                                                    </div>
                                                <?php else : ?>
                                                    <div id="reviewField<?php echo $book_info['Numero']; ?>" style="display: none;">
                                                        <p class="text-gray-500">No review available</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <!-- Edit button -->
                                            <button id="editButton<?php echo $book_info['Numero']; ?>" onclick="editReview(<?php echo $book_info['Numero']; ?>)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                Edit
                                            </button>
                                        </div>

                                        <form id="editReviewForm<?php echo $book_info['Numero']; ?>" style="display: none;" action="Save_review.php" method="post">
                                            <input type="hidden" name="book_id" value="<?php echo $book_info['Numero']; ?>">
                                            <div>
                                                <label for="ratingInput<?php echo $book_info['Numero']; ?>">Rating:</label>
                                                <div class="stars-container">
                                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                        <span class="star <?php if ($i <= $rating) echo 'star-yellow'; ?>" onclick="setRating(<?php echo $book_info['Numero']; ?>, <?php echo $i; ?>)">&#9733;</span>
                                                    <?php endfor; ?>
                                                    <input type="hidden" id="ratingInput<?php echo $book_info['Numero']; ?>" name="ratingInput<?php echo $book_info['Numero']; ?>" value="<?php echo $rating; ?>">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="reviewInput<?php echo $book_info['Numero']; ?>">Review:</label>
                                                <textarea id="reviewInput<?php echo $book_info['Numero']; ?>" name="reviewInput<?php echo $book_info['Numero']; ?>"><?php echo isset($row_review['review']) ? $row_review['review'] : ''; ?></textarea>
                                            </div>
                                            <div class="button-container">
                                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Save</button>
                                                <button type="button" onclick="cancelEdit(<?php echo $book_info['Numero']; ?>)" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>


                                        <script>
                                            function setRating(bookId, rating) {
                                                // Set the value of the hidden input field
                                                document.getElementById('ratingInput' + bookId).value = rating;
                                                // Update the star colors
                                                const stars = document.querySelectorAll('#editReviewForm' + bookId + ' .star');
                                                stars.forEach((star, index) => {
                                                    if (index < rating) {
                                                        star.classList.add('star-yellow');
                                                    } else {
                                                        star.classList.remove('star-yellow');
                                                    }
                                                });
                                            }

                                            function showFullReview(bookNumero) {
                                                var shortReview = document.getElementById('shortReview' + bookNumero);
                                                var fullReview = document.getElementById('fullReview' + bookNumero);
                                                var hideLink = document.getElementById('hideReview' + bookNumero);
                                                shortReview.style.display = 'none';
                                                fullReview.classList.remove('hidden');
                                                hideLink.classList.remove('hidden');
                                            }

                                            function hideFullReview(bookNumero) {
                                                var shortReview = document.getElementById('shortReview' + bookNumero);
                                                var fullReview = document.getElementById('fullReview' + bookNumero);
                                                var hideLink = document.getElementById('hideReview' + bookNumero);
                                                shortReview.style.display = '';
                                                fullReview.classList.add('hidden');
                                                hideLink.classList.add('hidden');
                                            }


                                            function editReview(bookId) {
                                                // Hide the review container
                                                document.getElementById('reviewContainer' + bookId).style.display = 'none';
                                                // Hide the edit button
                                                document.getElementById('editButton' + bookId).style.display = 'none';
                                                // Show the edit form
                                                document.getElementById('editReviewForm' + bookId).style.display = 'block';
                                            }

                                            function cancelEdit(bookId) {
                                                // Show the review container
                                                document.getElementById('reviewContainer' + bookId).style.display = 'block';
                                                // Show the edit button
                                                document.getElementById('editButton' + bookId).style.display = 'block';
                                                // Hide the edit form
                                                document.getElementById('editReviewForm' + bookId).style.display = 'none';
                                            }
                                        </script>

                                    <?php else : ?>
                                        <!-- Display button to add a new review -->
                                        <button id="addButton<?php echo $book_info['Numero']; ?>" onclick="openReviewForm(<?php echo $book_info['Numero']; ?>, false)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Add Review
                                        </button>

                                    <?php endif; ?>
                                    <form id="reviewFormLeave<?php echo $book_info['Numero']; ?>" class="hidden review-form" action="Leave_review.php" method="post">
                                        <input type="hidden" name="book_id" value="<?php echo $book_info['Numero']; ?>">
                                        <input type="hidden" name="rating" id="ratingInputLeave<?php echo $book_info['Numero']; ?>" value="<?php echo isset($row['rating']) ? $row['rating'] : '0'; ?>">
                                        <input type="hidden" id="hasReviewedBook<?php echo $book_info['Numero']; ?>" value="<?php echo $hasReviewed ? '1' : '0'; ?>">
                                        <div class="mt-4">
                                            <label for="reviewLeave<?php echo $book_info['Numero']; ?>" class="block text-sm font-medium text-gray-700">Your Rating</label>
                                            <div class="flex">
                                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                    <?php
                                                    $checked = isset($row['rating']) && $i <= $row['rating'] ? 'text-yellow-500' : '';
                                                    ?>
                                                    <span onclick="selectRatingLeave(<?php echo $book_info['Numero']; ?>, <?php echo $i; ?>)" class="star<?php echo $book_info['Numero']; ?> text-xl cursor-pointer <?php echo $checked; ?>">&#9733;</span>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <label for="reviewLeave<?php echo $book_info['Numero']; ?>" class="block text-sm font-medium text-gray-700">Your Review</label>
                                            <textarea id="reviewLeave<?php echo $book_info['Numero']; ?>" name="review" rows="4" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Enter your review"><?php echo isset($row['review']) ? $row['review'] : ''; ?></textarea>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Submit Review
                                            </button>
                                            <button type="button" onclick="cancelReviewFormLeave(<?php echo $book_info['Numero']; ?>)" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Define JavaScript variable to hold hasReviewed value
        var hasReviewed = <?php echo $hasReviewed ? 'true' : 'false'; ?>;

        function openReviewForm(bookId, hasReviewed) {
            // Close any previously opened review forms
            closeAllReviewForms();

            // Hide the "Add Review" button only if the user has not already reviewed the book
            if (!hasReviewed) {
                var addButton = document.getElementById('addButton' + bookId);
                if (addButton !== null) {
                    addButton.style.display = "none";
                }
            }

            // Show the review form
            var reviewForm = document.getElementById('reviewFormLeave' + bookId);
            if (reviewForm !== null) {
                reviewForm.style.display = "block";
            }
        }

        // Function to close all review forms
        function closeAllReviewForms() {
            // Get all elements with class 'review-form' and hide them
            const reviewForms = document.querySelectorAll('.review-form');
            reviewForms.forEach(form => form.style.display = "none");

            // Show all "Add Review" buttons
            const addReviewButtons = document.querySelectorAll('[id^="addButton"]');
            addReviewButtons.forEach(button => button.style.display = "inline-block");
        }


        function cancelReviewFormLeave(bookId) {
            // Hide all other review forms
            closeAllReviewForms();

            // Reset the star ratings if they exist
            resetStarRatings('ratingInputLeave' + bookId, 'star' + bookId);
            // Clear the review textarea if it exists
            var reviewTextarea = document.getElementById('reviewLeave' + bookId);
            if (reviewTextarea !== null) {
                reviewTextarea.value = '';
            }
            // Show the "Add Review" button
            var addButton = document.getElementById('addButton' + bookId);
            if (addButton !== null && addButton.style.display === "none") {
                addButton.style.display = "inline-block";
            }
        }



        // Function to reset star ratings
        function resetStarRatings(ratingInputId, starClassPrefix) {
            // Get all star elements
            const stars = document.querySelectorAll(`.${starClassPrefix}`);
            // Remove star-yellow class from all stars
            stars.forEach(star => star.classList.remove('star-yellow'));
            // Reset the rating input value
            document.getElementById(ratingInputId).value = '0';
        }


        // Function to select rating when editing review
        function selectRatingEdit(bookId, rating) {
            for (let i = 1; i <= 5; i++) {
                const star = document.querySelector(`#ratingInputEdit${bookId}`).parentNode.querySelector(`.star${bookId}:nth-child(${i})`);
                if (i <= rating) {
                    star.classList.add('star-yellow');
                } else {
                    star.classList.remove('star-yellow');
                }
            }
            document.querySelector(`#ratingInputEdit${bookId}`).value = rating;
        }

        // Function to select rating when leaving a review
        function selectRatingLeave(bookId, rating) {
            for (let i = 1; i <= 5; i++) {
                const star = document.querySelector(`#ratingInputLeave${bookId}`).parentNode.querySelector(`.star${bookId}:nth-child(${i})`);
                if (i <= rating) {
                    star.classList.add('star-yellow');
                } else {
                    star.classList.remove('star-yellow');
                }
            }
            document.querySelector(`#ratingInputLeave${bookId}`).value = rating;
        }
    </script>
    <!-- Mobile Menu JavaScript -->
    <script>
        document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
            var mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>

</html>