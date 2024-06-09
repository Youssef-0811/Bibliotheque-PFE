<!-- ok -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Book Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="header-footer2.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #ffffff;
      color: #1a202c;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1200px;
      margin: 20px auto;
      padding: 20px;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .book-details img {
      width: 150px;
      height: 100px;
      border-radius: 10px;
    }

    .author-info {
      margin-bottom: 20px;
    }

    .author-name {
      font-size: 24px;
      font-weight: bold;
      color: #1a202c;
    }

    .book-info {
      list-style-type: none;
      padding: 0;
    }

    .book-info li {
      margin-bottom: 10px;
      font-size: 16px;
    }

    .info-label {
      font-weight: bold;
      color: #007bff;
    }

    .book-summary {
      margin-top: 20px;
      padding: 10px;
      background-color: #f9f9f9;
      border-radius: 10px;
    }

    .reviews {
      margin-top: 20px;
    }

    .review {
      display: flex;
      margin-bottom: 20px;
    }

    .reviewer-avatar {
      width: 50px;
      height: 50px;
      background-color: #ddd;
      border-radius: 50%;
    }

    .reviewer-info {
      margin-left: 20px;
    }

    .reviewer-name {
      font-weight: bold;
    }

    .review-comment {
      margin: 0;
    }

    .no-reviews {
      color: #888;
    }

    .button {
      padding: 10px 20px;
      background-color: black;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: #292929;
    }

    .review-rating {
      font-size: 16px;
    }

    .star {
      color: #ccc;
    }

    .filled {
      color: gold;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .other-books {
      margin-top: 40px;
    }

    .other-books img {
      width: max-content;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }

    .book-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 10px;
      margin-bottom: 20px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .book-title {
      min-height: 3em;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>

<body>
  <header>
    <?php
    include('HF/header2.php');
    include('DataBase.php');
    ?>

  </header>

  <main class="container" style="padding-top: 90px;">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitLiv'])) {
      $id_livre = mysqli_real_escape_string($conn, $_POST['id-livre']);

      $sql = "SELECT * FROM livres WHERE Numero = $id_livre ";
      $result = mysqli_query($conn, $sql);
      $ligne = mysqli_fetch_assoc($result);

      $sqlaut = "SELECT livres.Image AS livre_image,
                        livres.Titre AS livre_titre,
                        auteurs.Nom AS auteur_nom,
                        auteurs.Bio AS auteur_bio,
                        format.Nom AS format_nom,
                        livres.Auteur_Id AS Id_Auteur,
                        livres.Disponible AS livre_disponible,
                        book_review.id_client AS reviewer_id,
                        book_review.review AS review_comment,
                        book_review.rating AS review_rating,
                        user.Nom AS reviewer_name
                    FROM livres
                    INNER JOIN auteurs ON livres.Auteur_Id = auteurs.Id
                    INNER JOIN format ON livres.Format_Id = format.Id
                    LEFT JOIN book_review ON livres.Numero = book_review.id_book
                    LEFT JOIN user ON book_review.id_client = user.ID
                    WHERE livres.Numero = $id_livre";
      $resultaut = mysqli_query($conn, $sqlaut);

      // Initialize $ligneaut
      $ligneaut = null;
      if ($resultaut && mysqli_num_rows($resultaut) > 0) {
        $ligneaut = mysqli_fetch_assoc($resultaut);
      }

      // Fetch other books by the same author
      $sqlOtherBooks = "SELECT Numero, Titre, Image FROM livres WHERE Auteur_Id = (SELECT Auteur_Id FROM livres WHERE Numero = $id_livre) AND Numero != $id_livre LIMIT 4";
      $resultOtherBooks = mysqli_query($conn, $sqlOtherBooks);
    }

    // Check if the book has reviews
    $hasReviews = ($ligneaut !== null);
    ?>

    <?php if ($result && mysqli_num_rows($result) > 0) { ?>
      <div class="row">
        <div class="col-lg-6">
          <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>" alt="Book Image" class="img-fluid" style="width: 75%; height: auto;">
        </div>

        <div class="col-lg-6">
          <div class="author-info">
            <h2 style="color: black;"><?php echo $ligne['Titre']; ?></h2>
            <h5 style="color: #888;"><?php echo $ligneaut['auteur_nom']; ?>
              <form action="testpage.php" method="post">
                <input type="hidden" name="idauteur" value="<?php echo $ligneaut['Id_Auteur']; ?>">
                <button type="submit" name="submitauteur" class="button bg-gray-500 text-white text-sm py-1 px-2 rounded">Learn More</button>
              </form>


              </h3>
          </div>
          <ul class="book-info">
            <li><span class="info-label" style="color: black;">Status:</span> <?php echo ($ligneaut['livre_disponible'] == 1 ? 'Available' : 'Not available'); ?></li>
            <li><span class="info-label" style="color: black;">Category:</span> <?php echo $ligneaut['format_nom']; ?></li>
          </ul>
          <div class="book-summary">
            <h4 class="section-title" style="color: black;">Summary</h4>
            <p style="color: #888;"><?php echo $ligne['Resume']; ?></p>
          </div>

          <form id="emprunterForm" action="Empr.php" method="post">
            <input type="hidden" name="titredelivre" value="<?php echo $ligne['Titre']; ?>">
            <input type="hidden" name="numerodelivre" value="<?php echo $ligne['Numero']; ?>">

            <?php if ($ligneaut['livre_disponible'] == 1) { ?>
              <div class="form-group">
                <label for="departureDate">Departure Date:</label>
                <input type="date" id="departureDate" name="departureDate" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="returnDate">Return Date:</label>
                <input type="date" id="returnDate" name="returnDate" class="form-control" required disabled>
              </div>
              <button class="button" id="submitBtn" type="submit" name="submit" disabled>Borrow</button>
            <?php } else { ?>
              <div class="form-group">
                <button class="button" style="background-color: #888; cursor: not-allowed;" id="submitBtn" type="button" disabled onmouseover="showUnavailableMessage()" onmouseout="hideUnavailableMessage()">Borrow</button>
                <div id="unavailableMessage" style="display: none; color: red;">This book is not available at the moment. Please check again later.</div>
              </div>
            <?php } ?>
          </form>

          <?php if ($hasReviews) { ?>
            <div class="reviews">
              <h4 class="section-title">Reviews</h4>
              <?php
              mysqli_data_seek($resultaut, 0); // Reset pointer to the start of result set
              $reviewCount = 0;
              while ($review_row = mysqli_fetch_assoc($resultaut)) {
                if ($reviewCount >= 3) break; // Stop after displaying three reviews
                $reviewCount++;
              ?>
                <div class="card mb-4 shadow-sm">
                  <div class="card-body">
                    <div class="reviewer-info">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="reviewer-name mb-0"><?php echo $review_row['reviewer_name']; ?></h5>
                        <div class="review-rating">
                          Rating:
                          <?php
                          $rating = $review_row['review_rating'];
                          for ($i = 1; $i <= 5; $i++) {
                            $starClass = ($i <= $rating) ? 'filled' : 'unfilled';
                            echo '<span class="star ' . $starClass . '">&#9733;</span>';
                          }
                          ?>
                        </div>
                      </div>
                      <p class="review-comment"><?php echo $review_row['review_comment']; ?></p>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
          <?php } else { ?>
            <p class="no-reviews">No comments at the moment</p>
          <?php }
          // End of reviews check
          ?>

          <?php if ($resultOtherBooks && mysqli_num_rows($resultOtherBooks) > 0) { ?>
            <div class="other-books">
              <h4 class="section-title text-center mb-4">More Books by This Author</h4>
              <div class="row">
                <?php while ($otherBook = mysqli_fetch_assoc($resultOtherBooks)) { ?>
                  <div class="col-6 col-md-3 mb-4">
                    <div class="book-card bg-white shadow rounded-lg pt-4 pb-4 pr-2 pl-2 h-100 flex flex-col items-center">
                      <div class="image-container w-full h-48 overflow-hidden rounded-md mb-2">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($otherBook['Image']); ?>" alt="Other Book Image" class="w-full h-full object-cover" />
                      </div>
                      <h5 class="mt-2 book-title text-center"><?php echo $otherBook['Titre']; ?></h5>
                      <form action="page-info.php" method="post" class="form1 mt-2">
                        <input type="hidden" name="id-livre" value="<?php echo $otherBook['Numero']; ?>">
                        <button type="submit" name="submitLiv" class="button bg-gray-500 text-white text-sm py-1 px-2 rounded">Learn More</button>
                      </form>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>


        </div>
      </div>
    <?php } ?>

  </main>

  <!-- Random Books Section -->
  <h2 class="text-2xl font-bold text-center mb-8">Decouvrez plus de livres</h2>

  <?php
  // Fetch 8 random books
  $sqlRandomBooks = "SELECT * FROM livres  JOIN format ON livres.Format_Id = format.Id ORDER BY RAND() LIMIT 8";
  $resultRandomBooks = mysqli_query($conn, $sqlRandomBooks);
  ?>
  <div class="arrivals py-8 px-4" style="padding-left: 50px; padding-right: 50px; overflow-x: auto; white-space: nowrap;">
    <div class="grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4" style="display: inline-flex;"> <!-- Changed display to inline-flex and set gap to 5px -->
      <?php while ($randomBook = mysqli_fetch_assoc($resultRandomBooks)) { ?>
        <div class="card" style="display: inline-block; flex: 0,0,0;"> <!-- Removed flex: 0 0 auto -->
          <div class="card bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300" style="height: 450px; width: 200px; background-color: #F3F4F6;"> <!-- Adjusted height and width, added background color -->
            <div class="relative h-40 overflow-hidden rounded-t-lg bg-gray-200"> <!-- Adjusted height, added background color -->
              <img src="data:image/jpeg;base64,<?php echo base64_encode($randomBook['Image']); ?>" alt="Book cover" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300" style="width: 100%; height: 300px" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
              <div class="absolute bottom-2 left-2 text-white"> <!-- Adjusted bottom padding -->

              </div>
            </div>
            <div class="p-4"> <!-- Adjusted padding -->
              <h3 class="title1 text-sm"><?php echo $randomBook['Titre']; ?></h3> <!-- Adjusted text size -->
              <p class="category1 text-xs"><?php echo $randomBook['Nom']; ?></p> <!-- Adjusted text size -->

              <form action="page-info.php" method="post" class="form1">
                <input type="hidden" name="id-livre" value="<?php echo $randomBook['Numero']; ?>">
                <button type="submit" name="submitLiv" class="button " style="background-color: gray; font-size:smaller; padding: 5px 5px;">Learn More</button>
              </form>
            </div>
          </div>
        </div>
      <?php } ?>
    </div><!-- /.grid -->
  </div><!-- /.arrivals -->
  <!-- End of Random Books Section -->

  <footer>
    <?php
    include('HF/footer.php')
    ?>
  </footer>







  <script>
    function setMinDepartureDate() {
      const departureDateInput = document.getElementById('departureDate');
      const today = new Date().toISOString().split('T')[0];
      departureDateInput.setAttribute('min', today);
    }

    function setMaxReturnDate() {
      const departureDateInput = document.getElementById('departureDate');
      const returnDateInput = document.getElementById('returnDate');

      departureDateInput.addEventListener('change', function() {
        if (this.value) {
          const departureDateValue = new Date(this.value);
          const maxReturnDate = new Date(departureDateValue);
          maxReturnDate.setDate(maxReturnDate.getDate() + 15);
          returnDateInput.setAttribute('max', maxReturnDate.toISOString().split('T')[0]);
          returnDateInput.removeAttribute('disabled');

          if (new Date(returnDateInput.value) > maxReturnDate) {
            returnDateInput.value = '';
          }
        } else {
          returnDateInput.value = '';
          returnDateInput.setAttribute('disabled', 'disabled');
        }
        toggleSubmitButton();
      });

      returnDateInput.addEventListener('change', function() {
        toggleSubmitButton();
      });
    }

    function toggleSubmitButton() {
      const departureDateInput = document.getElementById('departureDate');
      const returnDateInput = document.getElementById('returnDate');
      const submitBtn = document.getElementById('submitBtn');

      if (departureDateInput.value && returnDateInput.value) {
        submitBtn.removeAttribute('disabled');
      } else {
        submitBtn.setAttribute('disabled', 'disabled');
      }
    }

    function showUnavailableMessage() {
      document.getElementById('unavailableMessage').style.display = 'block';
    }

    function hideUnavailableMessage() {
      document.getElementById('unavailableMessage').style.display = 'none';
    }

    window.onload = function() {
      if (document.getElementById('departureDate')) {
        setMinDepartureDate();
        setMaxReturnDate();
      }
    };
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>