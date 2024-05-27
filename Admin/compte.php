<?php
session_start(); // Start the session
include("../DataBase.php");

// Check if admin is logged in, if not redirect to login page
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: ../Login/admin/AdminLogin.php");
    exit();
}

// Fetch admin information from the database
$query_admin_info = "SELECT * FROM admin WHERE Id = " . $_SESSION['admin_id'];
$result_admin_info = mysqli_query($conn, $query_admin_info);

if ($result_admin_info && mysqli_num_rows($result_admin_info) > 0) {
    $admin_info = mysqli_fetch_assoc($result_admin_info);

    // Retrieve admin's name and other details
    $admin_name = $admin_info['Nom'] ?? '';
    $admin_lastname = $admin_info['Prenom'] ?? '';
    $admin_email = $admin_info['Email'] ?? '';
    $admin_phone = $admin_info['Phone'] ?? '';

    // Retrieve and decode the image data
    $image_data = $admin_info['Image'] ?? '';
    $image_type = $admin_info['ImageType'] ?? '';
} else {
    // Handle error if unable to fetch admin information
    $error = "Unable to fetch admin information";
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Aude Velly Menut">
    <title>WeBook - Gestion de livres</title>
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <style>
        /* CSS to hide the dropdown initially */
        .dropdown-menu {
            display: none;
        }

        /* CSS to show the dropdown when hovering over the admin's name or image */
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }

        .pr-5 {
            padding-right: 600px;
            /* Adjust as needed */
        }

        /* 
    .pl-5 {
        padding-left: 0;
       
    }

    */
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="AdminDash.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-book"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Webook</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
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
                <a class="nav-link" href="Livres/Book.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Livres</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Documents/Documents.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Documents</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Auteurs/Auteur.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Auteurs</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Genres/Genre.php">
                    <i class="fas fa-fw fa-swatchbook"></i>
                    <span>Genres</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Format/Format.php">
                    <i class="fas fa-fw fa-align-left"></i>
                    <span>Formats</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="ConfirmEmprunt/Comfirmemprunt.php">
                    <i class="fas fa-fw fa-align-left"></i>
                    <span>Confirm Emprunt</span></a>
            </li>
        </ul>
        <!-- End of Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <div class="input-group-append">
                                <h4>Modifier les informations de l'administrateur</h4>
                            </div>
                        </div>
                    </form>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow" style="margin-right: 10px;">
                            <a class="nav-link dropdown-toggle" href="Deconexion.php" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-lg-inline text-gray-600 "><?php echo $admin_name; ?></span>
                                <!-- Display decrypted image -->
                                <img class="img-profile rounded-circle" src="data:<?php echo $image_type; ?>;base64,<?php echo base64_encode($image_data); ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="Deconexion.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Deconnexion
                                </a>
                                <a class="dropdown-item" href="compte.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Compte
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <div class="container-fluid">
                    <div class="container">
                        <!-- Display admin information -->
                        <form method="post" action="modifInfos.php" enctype="multipart/form-data">
                            <label for="admin_image">Image:</label>
                            <div class="d-flex align-items-center mb-3">
                                <div class="image-preview">
                                    <img src="data:<?php echo $admin_info['ImageType']; ?>;base64,<?php echo base64_encode($admin_info['Image']); ?>" width="100px" class="img-fluid rounded" alt="Admin Image">
                                </div>
                                <div class="ml-3">
                                    <!-- Input field to upload a new image -->
                                    <input type="file" class="form-control-file" id="admin_image" name="admin_image" accept="image/jpg" accept="image/png">
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="admin_name">Nom:</label>
                                <input type="text" class="form-control" id="admin_name" name="admin_name" value="<?php echo $admin_name; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="admin_lastname">Prénom:</label>
                                <input type="text" class="form-control" id="admin_lastname" name="admin_lastname" value="<?php echo $admin_lastname; ?>">
                            </div>
                            <div class="form-group">
                                <label for="admin_email">Email:</label>
                                <input type="email" class="form-control" id="admin_email" name="admin_email" value="<?php echo $admin_email; ?>">
                            </div>
                            <div class="form-group">
                                <label for="admin_phone">Téléphone:</label>
                                <input type="text" class="form-control" id="admin_phone" name="admin_phone" value="<?php echo $admin_phone; ?>">
                            </div>
                            <!-- Admin details to be hidden initially -->
                            <!-- <div id="adminDetails" style="margin-bottom: 10px;">
                                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                            </div> -->
                            <?php if (isset($info_error)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $info_error; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($password_error)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $password_error; ?>
                                </div>
                            <?php endif; ?>
                            <!-- Form for changing password (initially hidden) -->
                            <div id="changePasswordForm" style="display: none;">

                                <div class="form-group">
                                    <label for="old_password">Ancien mot de passe:</label>
                                    <input type="password" class="form-control" id="old_password" name="old_password">
                                </div>
                                <div class="form-group">
                                    <label for="new_password">Nouveau mot de passe:</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_new_password">Confirmer le nouveau mot de passe:</label>
                                    <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password">
                                </div>
                                <!-- <button type="submit" class="btn btn-primary">Changer le mot de passe</button> -->

                            </div>
                            <!-- Button to change password separately -->
                            <button type="button" class="btn btn-secondary" id="changePasswordBtn" style="margin-bottom: 10px;">Changer le mot de passe</button>
                            <!-- Button to toggle admin details -->
                            <button type="submit" class="btn btn-primary" name="update_info" style="margin-bottom: 10px;">Modifier les informations</button>



                            <a href="adminDash.php" class="btn btn-secondary" style="margin-bottom: 8.5px;">Retour à l'admin Dashboard</a>
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <!-- Include your footer content here -->
                <!-- End of Footer -->
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <!-- Include your scroll to top button here -->
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script>
        // JavaScript to toggle visibility of admin details
        document.getElementById("editAdminBtn").addEventListener("click", function() {
            var adminDetails = document.getElementById("adminDetails");
            if (adminDetails.style.display === "none") {
                adminDetails.style.display = "block";
            } else {
                adminDetails.style.display = "none";
            }
        });
    </script>
    <script>
        var adminDetails = document.getElementById("adminDetails");
        var changePasswordForm = document.getElementById("changePasswordForm");
        var changePasswordBtn = document.getElementById("changePasswordBtn");
        var editAdminBtn = document.getElementById("editAdminBtn");
        var retourBtn = document.getElementById("retourBtn");

        // Function to show password change form and hide admin details
        function showPasswordForm() {
            changePasswordForm.style.display = "block";
            adminDetails.style.display = "none";
            // Move all buttons down
            changePasswordBtn.style.marginBottom = "10px";
            editAdminBtn.style.marginBottom = "10px";
            retourBtn.style.marginBottom = "10px";
            return false; // Prevent default behavior of the link
        }

        // Function to hide password change form and show admin details
        function hidePasswordForm() {
            changePasswordForm.style.display = "none";
            adminDetails.style.display = "block";
            // Reset button margins
            changePasswordBtn.style.marginBottom = "";
            editAdminBtn.style.marginBottom = "";
            retourBtn.style.marginBottom = "";
            return false; // Prevent default behavior of the link
        }

        // JavaScript to toggle visibility of password change form
        document.addEventListener("DOMContentLoaded", function() {
            const changePasswordForm = document.getElementById("changePasswordForm");
            const changePasswordBtn = document.getElementById("changePasswordBtn");
            const editAdminBtn = document.getElementById("editAdminBtn");

            // Function to toggle visibility of password change form
            function togglePasswordForm() {
                changePasswordForm.style.display = (changePasswordForm.style.display === "none") ? "block" : "none";
            }

            // Event listener for change password button
            changePasswordBtn.addEventListener("click", function() {
                togglePasswordForm();
            });

            // Event listener for edit admin button (to hide password form)
            editAdminBtn.addEventListener("click", function() {
                changePasswordForm.style.display = "none"; // Hide password form when editing admin info
            });
        });
    </script>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>
</body>

</html>