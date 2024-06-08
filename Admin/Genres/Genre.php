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
            <li class="nav-item active">
                <a class="nav-link" href="#">
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
                                <h1 class="h3 text-gray-800">Genres</h1>
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

                    <!-- Include jQuery -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                    <!-- Page Heading -->
                    <div class="card border-left-primary shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Les genres disponibles</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-bordered dataTable" id="dataTable" role="grid" aria-describedby="dataTable_info" style="width: 100%;" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 25.5px;" aria-sort="ascending" aria-label="Name: activate to sort column descending"></th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">Nom</th>
                                                        <th style="width: 150px;">Actions</th> <!-- Add column for actions -->
                                                    </tr>
                                                </thead>
                                                <tbody id="genres">
                                                    <?php
                                                    // Include the FetchG.php file to obtain genres' data
                                                    include("FetchG.php");
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- jQuery script to fetch data from fetchG.php and populate it into the table
                    <script>
                        $(document).ready(function() {
                            $.ajax({
                                url: "fetchG.php",
                                type: "GET",
                                success: function(data) {
                                    $("#Genre").html(data);
                                }
                            });
                        });
                    </script> -->



                </div>
                <div class="card border-left-primary shadow mb-4" style="margin-left: 24px;margin-right: 24px;">
                    <div class="card-header py-3">
                        <h6 id="titleForm" class="m-0 font-weight-bold text-primary">Ajouter un genre</h6>
                    </div>
                    <div class="card-body">
                        <form id="addGenreForm" action="AddG.php" method="post">
                            <div class="form-group">
                                <label for="nameGenre">Nom du genre</label>
                                <input required type="text" class="form-control" id="nameGenre" name="nameGenre">

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
    <script src="js/genres.js"></script>
    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="deleteModalText"></p>
            <div style="text-align: center;">
                <button id="deleteButton" class="btn btn-danger">Delete</button>
                <button id="cancelDeleteButton" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="editForm" action="editGenre.php" method="POST">
                <input type="hidden" id="genreId" name="genreId" value="">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name"><br>
                <div style="text-align: center;">
                    <button id="saveEditButton" class="btn btn-primary">Save</button>
                    <button id="cancelEditButton" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom scripts for all pages -->
    <script src="js/common.js"></script>
    <script src="js/genres.js"></script>
    <script>
        function openEditModal(genreId, genreName) {
            var modal = document.getElementById('editModal');
            var form = document.getElementById('editForm');

            if (modal && form) {
                form.elements['genreId'].value = genreId;
                form.elements['name'].value = genreName;

                modal.style.display = "block";

                var cancelButton = document.getElementById('cancelEditButton');
                var closeButton = document.querySelector('#editModal .close');

                cancelButton.addEventListener('click', function() {
                    modal.style.display = "none";
                });

                closeButton.addEventListener('click', function() {
                    modal.style.display = "none";
                });

                form.onsubmit = function(event) {
                    event.preventDefault();
                    var formData = new FormData(form);
                    fetch('./editGenre.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            if (data.includes("Genre updated successfully")) {
                                modal.style.display = "none";
                                window.location.reload();
                            } else {
                                alert('Error updating genre: ' + data);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                };
            } else {
                console.error("Modal or form element not found");
            }
        }

        window.onclick = function(event) {
            var modal = document.getElementById("editModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }


        function showDeleteModal(genreId, genreName) {
            var modal = document.getElementById('deleteModal');
            var modalText = document.getElementById('deleteModalText');
            modalText.innerHTML = "Are you sure you want to delete " + genreName + "?";

            var deleteButton = document.getElementById('deleteButton');
            var cancelDeleteButton = document.getElementById('cancelDeleteButton');

            deleteButton.onclick = function() {
                // Redirect to the delete script with genre ID
                window.location.href = "./deleteG.php?Id=" + genreId;
            }

            cancelDeleteButton.onclick = function() {
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


</body>

</html>