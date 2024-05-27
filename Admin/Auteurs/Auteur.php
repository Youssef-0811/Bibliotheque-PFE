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

</head>
<style>
    /* CSS to hide the dropdown initially */
    .dropdown-menu {
        display: none;
    }

    /* CSS to show the dropdown when hovering over the admin's name or image */
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
    }

    .highlight {
        background-color: #f2f2f2;
        /* Or any other color you prefer */
    }
</style>
<?php
session_start(); // Start the session
include("../../DataBase.php");

// Check if admin is logged in, if not redirect to login page
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: ../../AdminLogin.php");
    exit();
}

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
            <li class="nav-item ">
                <a class="nav-link" href="../Livres/Book.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Livres</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Documents/Documents.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Documents</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">
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

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <div class="input-group-append">
                                <h1 class="h3 text-gray-800">Auteurs</h1>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
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
                    <div class="card border-left-primary shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Les auteurs disponibles</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive <?php include("../../DataBase.php");

                                                            // Connexion à la base de données et exécution de la requête SQL
                                                            $sql = "SELECT * FROM auteurs";
                                                            $result = $conn->query($sql);

                                                            echo ($result && $result->num_rows > 3) ? 'scrollable-table' : ''; ?>" <?php echo ($result && $result->num_rows > 3) ? 'style="max-height: 400px;"' : ''; ?>>
                                <table class="table table-bordered dataTable" id="dataTable" role="grid" aria-describedby="dataTable_info" style="width: 100%;" width="100%" cellspacing="0">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 55.5px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">Image</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Prénom</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Nom</th>
                                            <th class="biography" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Biographie</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Date de naissance</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="authors">
                                        <?php
                                        // Include the FetchA.php file to obtain authors' data
                                        include("FetchA.php");
                                        ?>
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>













                <div class="card border-left-primary shadow mb-4" style="margin-left: 24px;margin-right: 24px;">
                    <div class="card-header py-3">
                        <h6 id="titleForm" class="m-0 font-weight-bold text-primary">Ajouter un auteur</h6>
                    </div>
                    <div class="card-body">
                        <form id="addAuthorForm" action="AddA.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input required type="text" class="form-control" id="nom" name="nom">
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input required type="text" class="form-control" id="prenom" name="prenom">
                            </div>
                            <div class="form-group">
                                <label for="date_naissance">Date de naissance</label>
                                <input required type="date" class="form-control" id="date_naissance" name="date_naissance">
                                <div id="date_naissance" style="color:red;display:none;"></div>
                            </div>
                            <div class="form-group">
                                <label for="bio">Biographie</label>
                                <textarea id="bio" class="form-control" name="bio"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input required type="file" class="form-control" id="image" name="image">
                                <br>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Valider</button>
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

    <!-- Delete Modal -->
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



    <!-- Custom scripts for all pages-->
    <script src="js/common.js"></script>
    <script src="js/authors.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const authorId = urlParams.get('id');
            const redirected = urlParams.get('redirected'); // Check if redirected from another page
            if (authorId && redirected) {
                highlightAuthor(authorId);
                setTimeout(function() {
                    scrollToAuthor(authorId);
                }, 200);
            }
        });

        function highlightAuthor(authorId) {
            const authorRow = document.querySelector('tr[data-author-id="' + authorId + '"]');
            if (authorRow) {
                authorRow.classList.add('highlight');
                setTimeout(function() {
                    authorRow.classList.remove('highlight');
                }, 700);

            }
        }

        function scrollToAuthor(authorId) {
            const authorRow = document.querySelector('tr[data-author-id="' + authorId + '"]');
            if (authorRow) {
                const tableContainer = document.querySelector('.scrollable-table');
                if (tableContainer) {
                    tableContainer.scrollTop = authorRow.offsetTop - tableContainer.offsetTop;
                }
            }
        }
    </script>


    <script>
        function showDeleteModal(authorId, authorName) {
            var modal = document.getElementById('deleteModal');
            var modalText = document.getElementById('deleteModalText');
            modalText.innerHTML = "Are you sure you want to delete " + authorName + "?";

            var deleteButton = document.getElementById('deleteButton');
            var cancelButton = document.getElementById('cancelButton');

            deleteButton.onclick = function() {
                // Redirect to the delete script with author ID
                window.location.href = "deleteA.php?id=" + authorId;
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





    <script>
        // Function to open edit modal
        function openEditModal(authorId, nom, prenom, dateNaissance, bio, imageUrl) {
            var modal = document.getElementById('editModal');
            var form = document.getElementById('editForm');

            // Check if the modal and form elements exist
            if (modal && form) {
                // Set form values with author data
                form.elements['editAuthorId'].value = authorId;
                form.elements['editNom'].value = nom;
                form.elements['editPrenom'].value = prenom;
                form.elements['editDateNaissance'].value = dateNaissance;
                form.elements['editBio'].value = bio;
                document.getElementById('currentImage').src = imageUrl;

                modal.style.display = "block";

                // Set up event listeners for cancel button and close "x" button
                var closeButton = document.querySelector('.close');
                var cancelButton = document.getElementById('cancelButton');

                closeButton.addEventListener('click', function() {
                    // Close the modal when close "x" button is clicked
                    modal.style.display = "none";
                });

                cancelButton.addEventListener('click', function() {
                    // Close the modal when cancel button is clicked
                    modal.style.display = "none";
                });

                // Handle form submission
                form.onsubmit = function(event) {
                    event.preventDefault(); // Prevent default form submission
                    // Submit the form data asynchronously
                    var formData = new FormData(form);
                    fetch('editAuteur.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            // Log server response
                            console.log(data);
                            // Check if the response contains the success message
                            if (data.includes("Author updated successfully")) {
                                // Display a success message
                                console.log('Author updated successfully');
                                // Close the modal
                                modal.style.display = "none";
                                // Reload the page only when the save operation is successful
                                window.location.reload();
                            } else {
                                // Display an error message
                                alert('Error updating author: ' + data);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error); // Log any errors
                        });
                };
            } else {
                console.error("Modal or form element not found");
            }
        }

        // Function to close the edit modal
        window.onclick = function(event) {
            var modal = document.getElementById('editModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    </script>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content" style="margin: 5% auto;">
            <span class="close">&times;</span>
            <h2>Edit Author</h2>
            <form id="editForm" action="editAuteur.php" method="post" enctype="multipart/form-data">
                <!-- Hidden input for author ID -->
                <input type="hidden" id="editAuthorId" name="editAuthorId">

                <div class="d-flex align-items-center mb-3">
                    <div>
                        <label for="currentImage">Current Image</label>
                        <img id="currentImage" src="<?php echo $imageUrl; ?>" width="150" class="img-fluid rounded" alt="Current Image">
                    </div>
                    <!-- Input field to choose an image -->
                    <div class="ml-3">
                        <label for="editImage">Choose an image</label>
                        <input type="file" class="form-control-file" id="editImage" name="editImage" accept="image/*">
                    </div>
                </div>
                <div class="form-group">
                    <label for="editNom">Nom</label>
                    <input type="text" class="form-control" id="editNom" name="editNom">
                </div>
                <div class="form-group">
                    <label for="editPrenom">Prénom</label>
                    <input type="text" class="form-control" id="editPrenom" name="editPrenom">
                </div>
                <div class="form-group">
                    <label for="editDateNaissance">Date de Naissance</label>
                    <input type="text" class="form-control" id="editDateNaissance" name="editDateNaissance">
                </div>
                <div class="form-group">
                    <label for="editBio">Biographie</label>
                    <textarea class="form-control" id="editBio" name="editBio"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-secondary" id="cancelButton">Cancel</button>
            </form>
        </div>
    </div>




</body>

</html>