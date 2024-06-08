<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Aude Velly Menut">

    <title>WeBook - Gestion de livres </title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<?php
session_start(); // Start the session

// Check if admin is logged in, if not redirect to login page
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: ../../AdminLogin.php");
    exit();
}
include("../../DataBase.php");


// Fetch admin information from the database
$query_admin_info = "SELECT * FROM admin WHERE Id = " . $_SESSION['admin_id'];
$result_admin_info = mysqli_query($conn, $query_admin_info);

if ($result_admin_info && mysqli_num_rows($result_admin_info) > 0) {
    $admin_info = mysqli_fetch_assoc($result_admin_info);

    // Retrieve admin's name and other details
    $admin_name = $admin_info['Nom'] ?? '';
    $image_data = $admin_info['Image'] ?? '';
    $image_type = $admin_info['ImageType'] ?? '';
} else {
    // Handle error if unable to fetch admin information
    $error = "Unable to fetch admin information";
}
?>

<style>
    /* CSS to hide the dropdown initially */
    .dropdown-menu {
        display: none;
    }

    /* CSS to show the dropdown when hovering over the admin's name or image */
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
    }

    /* Responsive Sidebar */
    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            top: 56px;
            left: -250px;
            width: 100px;
            height: calc(100% - 56px);
            z-index: 1;
            background-color: #343a40;
            overflow-x: hidden;
            transition: left 0.5s;
        }

        .show-sidebar {
            left: 0;
        }

        /* Hide the text of navigation items */
        .sidebar .nav-link span {
            display: none;
        }

        /* Show only the icons */
        .sidebar .nav-link i {
            margin-right: 0;
        }
    }

    /* Define color for the black bars */
    .black-bars {
        color: black;
    }
</style>
<script>
    // Responsive Sidebar Functionality
    $(document).ready(function() {
        $('#sidebarToggleTop').on('click', function() {
            console.log("Clicked on the menu button");
            $('.sidebar').toggleClass('show-sidebar');
        });
    });
</script>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../AdminDash.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-book"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Webook</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../AdminDash.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tableau de bord</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Gestion
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Livres</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Documents/Documents.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Documents</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Auteurs/Auteur.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Auteurs</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../User/User.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>User</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Genres/Genre.php">
                    <i class="fas fa-fw fa-swatchbook"></i>
                    <span>Genres</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Format/Format.php">
                    <i class="fas fa-fw fa-align-left"></i>
                    <span>Formats</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../../Admin/ConfirmEmprunt/Comfirmemprunt.php">
                    <i class="fas fa-fw fa-align-left"></i>
                    <span>Confirm Emprunt</span></a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars black-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <div class="input-group-append">
                                <h1 class="h3 text-gray-800">Livres</h1>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="user-info">
                                    <span class="username text-gray-600"><?= $admin_name; ?></span>
                                    <img class="img-profile rounded-circle" src="data:<?php echo $image_type; ?>;base64,<?php echo base64_encode($image_data); ?>">
                                </div>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../Deconexion.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Deconnexion
                                </a>
                                <a class="dropdown-item" href="../compte.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Compte
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- Ligne de statistiques -->


                    <div class="container-fluid" style="padding-right: 0px;padding-left: 0px;">
                        <!-- Page Heading -->
                        <div class="card border-left-primary shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Les livres disponibles</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-bordered dataTable" id="dataTable" role="grid" aria-describedby="dataTable_info" style="width: 100%;" width="100%" cellspacing="0">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 55.5px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">Image</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Titre</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Auteur</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">ISBN</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Parution</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="books">
                                            <?php
                                            include("../../DataBase.php");
                                            // Include the FetchB.php file to fetch livre data
                                            include("FetchB.php");
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for delete confirmation -->
                    <div id="deleteModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <p id="deleteModalText"></p>
                            <div style="text-align: center;">
                                <button id="deleteButton" class="btn btn-danger">Delete</button>
                                <button id="cancelButton" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>


                    <div class="card border-left-primary shadow mb-4">
                        <div class="card-header py-3">
                            <h6 id="titleForm" class="m-0 font-weight-bold text-primary">Ajouter un livre</h6>
                        </div>
                        <div class="card-body">
                            <form id="addBookForm" action="Addb.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="titleBook">Titre</label>
                                    <input required type="text" class="form-control" id="titleBook" name="titleBook">
                                </div>
                                <div class="form-group">
                                    <label for="authorBook">Auteur</label>
                                    <select class="form-control" id="authorBook" name="authorBook">
                                        <option value="">Choisissez un auteur</option>
                                        <?php
                                        include("../../DataBase.php");
                                        // Fetch authors from the database
                                        $sqlAuthors = "SELECT * FROM auteurs";
                                        $resultAuthors = $conn->query($sqlAuthors);
                                        if ($resultAuthors->num_rows > 0) {
                                            while ($rowAuthor = $resultAuthors->fetch_assoc()) {
                                                echo "<option value='" . $rowAuthor['Id'] . "'>" . $rowAuthor['Nom'] . " " . $rowAuthor['Prenom'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="genreBook">Genre</label>
                                    <select class="form-control" id="genreBook" name="genreBook">
                                        <option value="">Choisissez un genre</option>
                                        <?php
                                        include("../../DataBase.php");
                                        // Fetch genres from the database
                                        $sqlGenres = "SELECT * FROM genre";
                                        $resultGenres = $conn->query($sqlGenres);
                                        if ($resultGenres->num_rows > 0) {
                                            while ($rowGenre = $resultGenres->fetch_assoc()) {
                                                // Set the value of each option to the ID and display the name
                                                echo "<option value='" . $rowGenre['Id'] . "'>" . $rowGenre['nom'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="formatBook">Format</label>
                                    <select class="form-control" id="formatBook" name="formatBook">
                                        <option value="">Choisissez un format</option>
                                        <?php
                                        // Fetch formats from the database
                                        $sqlFormats = "SELECT * FROM format";
                                        $resultFormats = $conn->query($sqlFormats);
                                        if ($resultFormats->num_rows > 0) {
                                            while ($rowFormat = $resultFormats->fetch_assoc()) {
                                                echo "<option value='" . $rowFormat['Id'] . "'>" . $rowFormat['Nom'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="countPageBook">Nombre de pages</label>
                                    <input type="number" class="form-control" id="countPageBook" name="countPageBook">
                                </div>
                                <div class="form-group">
                                    <label for="releaseBook">Date de parution</label>
                                    <input required type="number" class="form-control" id="releaseBook" name="releaseBook">
                                    <div id="releaseInvalidBook" style="color:red;display:none;"></div>
                                </div>
                                <div class="form-group">
                                    <label for="isbnBook">ISBN</label>
                                    <input required type="number" class="form-control" id="isbnBook" name="isbnBook">
                                    <div id="isbnInvalidBook" style="color:red;display:none;"></div>
                                </div>
                                <div class="form-group">
                                    <label for="resumeBook">Résumé</label>
                                    <textarea class="form-control" id="resumeBook" name="resumeBook"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input required type="file" class="form-control" id="image" name="image">
                                    <br>
                                </div>
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </form>
                        </div>
                    </div>



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Custom scripts for all pages-->
    <script src="js/common.js"></script>
    <script src="js/books.js"></script>
    <script>
        // Function to display delete confirmation modal
        function showDeleteModal(livreId, livreTitle) {
            var modal = document.getElementById('deleteModal');
            var modalText = document.getElementById('deleteModalText');
            modalText.innerHTML = "Are you sure you want to delete the livre '" + livreTitle + "'?";

            var deleteButton = document.getElementById('deleteButton');
            var cancelButton = document.getElementById('cancelButton');

            deleteButton.onclick = function() {
                // Redirect to the delete script with livre ID
                window.location.href = "./DeleteBook.php?id=" + livreId;
            }

            cancelButton.onclick = function() {
                modal.style.display = "none";
            }

            modal.style.display = "block";

            var span = document.getElementsByClassName("close")[0];

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
    </script>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content" style="margin: 5% auto;">
            <span class="close">&times;</span>
            <h2>Edit Book</h2>
            <form id="editForm" action="EditBook.php" method="post" enctype="multipart/form-data">
                <!-- Hidden input for book ID -->
                <input type="hidden" id="editBookId" name="editBookId">



                <div class="d-flex align-items-center mb-3">
                    <div>
                        <label for="currentImage">Current Image</label>
                        <img id="currentImage" src="<?php echo $currentImageUrl; ?>" width="150" class="img-fluid rounded" alt="Current Image">
                    </div>
                    <!-- Input field to choose an image -->
                    <div class="ml-3">
                        <label for="editImage">Choose an image</label>
                        <input type="file" class="form-control-file" id="editImage" name="editImage" accept="image/*">
                    </div>
                </div>
                <div class="form-group">
                    <label for="editTitre">Titre</label>
                    <input type="text" class="form-control" id="editTitre" name="editTitre">
                </div>
                <div class="form-group">
                    <label for="editAuteurId">Auteur</label>
                    <select class="form-control" id="editAuteurId" name="editAuteurId">
                        <option value="">Choisissez un auteur</option>
                        <?php
                        // Fetch authors from the database
                        $sqlAuthors = "SELECT * FROM auteurs";
                        $resultAuthors = $conn->query($sqlAuthors);
                        if ($resultAuthors->num_rows > 0) {
                            while ($rowAuthor = $resultAuthors->fetch_assoc()) {
                                echo "<option value='" . $rowAuthor['Id'] . "'>" . $rowAuthor['Nom'] . " " . $rowAuthor['Prenom'] . "</option>";
                            }
                        }
                        ?>
                    </select>

                </div>
                <div class="form-group">
                    <label for="editGenreId">Genre</label>
                    <select class="form-control" id="editGenreId" name="editGenreId">
                        <option value="">Choisissez un genre</option>
                        <?php
                        include("../../DataBase.php");
                        // Fetch genres from the database
                        $sqlGenres = "SELECT * FROM genre";
                        $resultGenres = $conn->query($sqlGenres);
                        if ($resultGenres->num_rows > 0) {
                            while ($rowGenre = $resultGenres->fetch_assoc()) {
                                // Set the value of each option to the ID and display the name
                                echo "<option value='" . $rowGenre['Id'] . "'>" . $rowGenre['nom'] . "</option>";
                            }
                        }
                        ?>
                    </select>


                </div>
                <div class="form-group">
                    <label for="editFormatId">Format</label>
                    <select class="form-control" id="editFormatId" name="editFormatId">
                        <option value="">Choisissez un format</option>
                        <?php
                        // Fetch formats from the database
                        $sqlFormats = "SELECT * FROM format";
                        $resultFormats = $conn->query($sqlFormats);
                        if ($resultFormats->num_rows > 0) {
                            while ($rowFormat = $resultFormats->fetch_assoc()) {
                                echo "<option value='" . $rowFormat['Id'] . "'>" . $rowFormat['Nom'] . "</option>";
                            }
                        }
                        ?>
                    </select>

                </div>
                <div class="form-group">
                    <label for="editNbrPages">Nombre de pages</label>
                    <input type="text" class="form-control" id="editNbrPages" name="editNbrPages">
                </div>
                <div class="form-group">
                    <label for="editParution">Parution</label>
                    <input type="text" class="form-control" id="editParution" name="editParution">
                </div>
                <div class="form-group">
                    <label for="editISBN">ISBN</label>
                    <input type="text" class="form-control" id="editISBN" name="editISBN">
                </div>
                <div class="form-group">
                    <label for="editResume">Résumé</label>
                    <textarea class="form-control" id="editResume" name="editResume"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-secondary" id="cancelButton">Cancel</button>
            </form>
        </div>
    </div>
    <!-- End Edit Modal -->





    <script>
        // Function to toggle author dropdown
        function toggleAuthorDropdown() {
            var currentAuthor = document.getElementById('currentAuthor');
            var authorDropdown = document.getElementById('authorBook');

            if (currentAuthor.style.display === 'none') {
                currentAuthor.style.display = 'inline';
                authorDropdown.style.display = 'none';
            } else {
                currentAuthor.style.display = 'none';
                authorDropdown.style.display = 'inline';
            }
        }

        // Function to toggle genre dropdown
        function toggleGenreDropdown() {
            var currentGenre = document.getElementById('currentGenre');
            var genreDropdown = document.getElementById('genreBook');

            if (currentGenre.style.display === 'none') {
                currentGenre.style.display = 'inline';
                genreDropdown.style.display = 'none';
            } else {
                currentGenre.style.display = 'none';
                genreDropdown.style.display = 'inline';
            }
        }

        // Function to toggle format dropdown
        function toggleFormatDropdown() {
            var currentFormat = document.getElementById('currentFormat');
            var formatDropdown = document.getElementById('formatBook');

            if (currentFormat.style.display === 'none') {
                currentFormat.style.display = 'inline';
                formatDropdown.style.display = 'none';
            } else {
                currentFormat.style.display = 'none';
                formatDropdown.style.display = 'inline';
            }
        }

        // Close the modal when the user clicks outside of it
        window.onclick = function(event) {
            var modal = document.getElementById('editBookModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Close the modal when the user clicks the close button
        var closeButton = document.getElementById('editBookClose');
        if (closeButton) {
            closeButton.onclick = function() {
                var modal = document.getElementById('editBookModal');
                if (modal) {
                    modal.style.display = 'none';
                }
            }
        }
    </script>
</body>

</html>