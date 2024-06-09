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

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.css" rel="stylesheet">
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/6r6QF/QRTT13c94pjodroF9m3p2PLB9o4q1fOu/qlI=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<style>
    .book-list {
        max-height: 202px;
        /* 3 books * 64px per book */
        overflow-y: auto;
    }

    .highlight {
        background-color: #f2f2f2;
        /* Or any other color you prefer */
    }
</style>

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

    /* Modal */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
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
            <li class="nav-item active">
                <a class="nav-link" href="#">
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
                                <h1 class="h3 text-gray-800">Users</h1>
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


                    <div class="container-fluid" style="padding-right: 0px;padding-left: 0px;">
                        <!-- Page Heading -->
                        <div class="card border-left-primary shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Les Users</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" style="max-height: 220px; overflow-y: auto;">
                                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                        <!-- Search input for Nom Prenom -->
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="searchInput" placeholder="Recherche par Nom Prenom">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-bordered dataTable" id="dataTable" role="grid" aria-describedby="dataTable_info" style="width: 100%;" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Nom Prenom</th>
                                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Date de Naissance</th>
                                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Filiere</th>
                                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Livres Emprunter</th>
                                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="documents">
                                                        <?php
                                                        include("FetchU.php");
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Get the input field and table body
                            const searchInput = document.getElementById('searchInput');
                            const tableBody = document.getElementById('documents');

                            // Event listener for the input field
                            searchInput.addEventListener('input', function() {
                                const searchText = this.value.toLowerCase();
                                const rows = tableBody.getElementsByTagName('tr');

                                // Loop through all table rows and hide those that don't match the search query
                                for (let i = 0; i < rows.length; i++) {
                                    const row = rows[i];
                                    const cells = row.getElementsByTagName('td');
                                    const nameCell = cells[0]; // Index 0 is the "Nom Prenom" column

                                    // Check if cell text contains search query for Nom Prenom
                                    if (nameCell.innerText.toLowerCase().includes(searchText)) {
                                        row.style.display = '';
                                    } else {
                                        row.style.display = 'none';
                                    }
                                }
                            });
                        });
                    </script>






                    <div class="card-body2">

                    </div>




                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->





    </div>







    <!-- Delete User Modal -->
    <div id="deleteUserModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Delete User</h2>
            <p id="deleteUserConfirmation"></p>
            <button id="confirmDeleteUserButton" class="btn btn-danger">Yes</button>
            <button id="cancelDeleteUserButton" class="btn btn-secondary">Cancel</button>
        </div>
    </div>

    <script>
        // Function to open delete user modal
        function openDeleteUserModal(userName) {
            var modal = document.getElementById('deleteUserModal');
            var deleteUserConfirmation = document.getElementById('deleteUserConfirmation');
            deleteUserConfirmation.textContent = "Are you sure you want to delete " + userName + "?";

            var confirmDeleteUserButton = document.getElementById('confirmDeleteUserButton');
            var cancelDeleteUserButton = document.getElementById('cancelDeleteUserButton');

            confirmDeleteUserButton.onclick = function() {
                // Redirect to the delete script with user ID
                window.location.href = "deleteUser.php?id=" + userId;
            }

            cancelDeleteUserButton.onclick = function() {
                modal.style.display = "none";
            }

            modal.style.display = "block";

            // Set up event listener for close button
            var closeButton = document.querySelector('.close');
            closeButton.addEventListener('click', function() {
                modal.style.display = "none";
            });

            // Click outside modal to close
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
    </script>







    <!-- End of Page Wrapper -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            function highlightAndScrollToUser(userId) {
                // Remove highlight from all rows
                $('.highlight').removeClass('highlight');
                // Highlight the selected user's row
                const userRow = $('#user_' + userId);
                userRow.addClass('highlight');
                // Scroll to the selected user's row
                if (userRow.length > 0) {
                    $('#dataTable').animate({
                        scrollTop: userRow.offset().top - $('#dataTable').offset().top + $('#dataTable').scrollTop()
                    }, 500);
                }
                // Remove highlighting after 1 second
                setTimeout(function() {
                    userRow.removeClass('highlight');
                }, 500);
            }

            // Fetch the user ID from the URL parameters and highlight the corresponding row
            const urlParams = new URLSearchParams(window.location.search);
            const userId = urlParams.get('id');
            if (userId) {
                highlightAndScrollToUser(userId);
            }
        });
    </script>


    <script>
        function showBorrowedBooks(userId) {
            $.ajax({
                type: 'POST',
                url: 'FetchU_Books.php',
                data: {
                    userId: userId
                },
                success: function(response) {
                    // Display fetched books in the designated area
                    $('.card-body2').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>

</body>

</html>