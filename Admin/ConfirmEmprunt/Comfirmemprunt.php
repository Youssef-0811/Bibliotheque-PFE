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
    <script src="jquery-3.7.1.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


</head>

<style>
    .triangle {
        width: 35px;
        /* Adjust as needed */
        height: 35px;
        /* Adjust as needed */
        margin-right: 5px;
        /* Adjust as needed */
    }

    .tooltip-text {
        display: none;
    }

    .position-relative:hover .triangle {
        display: inline;
    }

    .position-relative:hover .tooltip-text {
        display: block;
    }

    .navbar-brand .sidebar-brand-text {
        margin-right: 5px;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        background-color: #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 0.35rem;
        padding: 0.5rem 0;
    }

    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
    }

    .navbar-nav.ml-auto .nav-item {
        margin-left: 1rem;
    }

    .navbar-nav.ml-auto .nav-item:last-child {
        margin-left: 0;
    }

    .img-profile {
        width: 40px;
        height: 40px;
    }

    .user-info {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .user-info .username {
        margin-right: 0.5rem;
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

            <li class="nav-item active">
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
                                <h1 class="h3 text-gray-800">Les Demande D'emprunt</h1>
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
                            <h6 class="m-0 font-weight-bold text-primary">Les Demande D'emprunt Non confirmer</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- Search input -->
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Recherche par nom ou par Id Emprunt">
                                </div>
                                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-bordered dataTable" id="dataTable" role="grid" aria-describedby="dataTable_info" style="width: 100%;" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">Id Emprunt</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">Nom Prenom</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">Titre du Livre</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">date_d'emprunt</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">date de retour</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="formats">
                                                    <?php
                                                    // Include the FetchA.php file to obtain authors' data
                                                    include("./FetchEmp.php");
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
                        const tableBody = document.getElementById('formats');

                        // Event listener for the input field
                        searchInput.addEventListener('input', function() {
                            const searchText = this.value.toLowerCase();
                            const rows = tableBody.getElementsByTagName('tr');

                            // Loop through all table rows and hide those that don't match the search query
                            for (let i = 0; i < rows.length; i++) {
                                const row = rows[i];
                                const cells = row.getElementsByTagName('td');
                                let found = false;

                                // Loop through all table cells in current row
                                for (let j = 0; j < cells.length; j++) {
                                    const cell = cells[j];
                                    const text = cell.innerText.toLowerCase();

                                    // Check if cell text contains search query
                                    if (text.includes(searchText)) {
                                        found = true;
                                        break;
                                    }
                                }

                                // Toggle row visibility based on search result
                                if (found) {
                                    row.style.display = '';
                                } else {
                                    row.style.display = 'none';
                                }
                            }
                        });
                    });
                </script>

            </div>
            <!-- End of Content Wrapper -->





            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="card border-left-primary shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">les client</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dataTable" id="dataTable" role="grid" aria-describedby="dataTable_info" style="width: 100%;" width="100%" cellspacing="0">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Id_client</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Nom</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Prenom</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">nombre de livre emprunter</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT DISTINCT user.Nom, user.ID, user.Prenom, emprunte_en_attente.id_client FROM user 
        JOIN emprunte_en_attente 
        ON user.ID = emprunte_en_attente.id_client";

                                    $result = $conn->query($sql);

                                    // Check if the query was successful
                                    if ($result && $result->num_rows > 0) {
                                        // Output data of each row
                                        while ($row = $result->fetch_assoc()) {

                                            $IDclient = $row['ID'];

                                            $sqlc = "SELECT COUNT(empruntconfirme.id_client) AS total_rows  FROM empruntconfirme WHERE empruntconfirme.id_client= ? ";
                                            $stmtc = $conn->prepare($sqlc);
                                            $stmtc->bind_param('s', $IDclient);
                                            $stmtc->execute();
                                            $resultc = $stmtc->get_result();
                                            $rowc = $resultc->fetch_assoc();
                                            // Extract the count from the result
                                            $rowCount = $rowc['total_rows'];

                                            // Add the "danger" class if the number of borrowed books exceeds 4
                                            $dangerClass = ($rowCount > 4) ? 'table-danger' : '';

                                    ?>
                                            <tr>
                                                <td><?php echo $IDclient ?></td>
                                                <td><?php echo $row['Nom']; ?></td>
                                                <td><?php echo $row['Prenom']; ?></td>
                                                <td class="position-relative">
                                                    <?php if ($rowCount > 4) : ?>
                                                        <div class="tooltip-text position-absolute top-100 start-0 translate-middle-x bg-danger px-1 py-2 rounded" style="bottom: 44px; color: #fff;">
                                                            This user has more than 4 borrowed books
                                                        </div>
                                                        <img src="../../images/icons/Alert.png" class="triangle">
                                                        <?php echo $rowCount; ?>
                                                    <?php elseif ($rowCount > 0) : ?>
                                                        <img src="../../images/icons/Alert.png" class="triangle" style="display: none;">
                                                        <?php echo $rowCount; ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                    <?php
                                        }
                                    }
                                    ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <!-- End of Page Wrapper -->





        <!-- confirm Modal -->
        <div id="confirmModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p id="confirmempModalText"></p>
                <div style="text-align: center;">
                    <button id="confirmbutton" class="btn btn-danger">confirm</button>
                    <button id="cancelconfirm" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>




        <!-- Custom scripts for all pages-->

        <script>
            function confirmEmp(Idempr, id_client, Titre, date_emprunt, date_retour, NumeroLivre) {
                var modal = document.getElementById('confirmModal');
                var modalText = document.getElementById('confirmempModalText');
                modalText.innerHTML = "Are you sure you want to confirm " + Titre + "?";

                var confirmbutton = document.getElementById('confirmbutton');
                var cancelconfirm = document.getElementById('cancelconfirm');

                confirmbutton.onclick = function() {
                    // AJAX request to send data to the PHP script
                    // AJAX request to send data to the PHP script
                    $.ajax({
                        type: "POST",
                        url: "Confirmemp.php",
                        dataType: "text",
                        data: {
                            EMPId: Idempr,
                            idclient: id_client,
                            Titre: Titre,
                            dateemp: date_emprunt,
                            dateR: date_retour,
                            NumL: NumeroLivre
                        },
                        success: function(response) {
                            // Handle the response from PHP
                            console.log(response);
                            // You can perform additional actions based on the response if needed
                            modal.style.display = "none"; // Hide the modal after successful submission
                            location.reload(); // Reload the page
                        },
                        error: function(xhr, status, error) {
                            // Handle AJAX errors
                            console.error("AJAX Error: " + error);
                        }
                    });


                }

                cancelconfirm.onclick = function() {
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