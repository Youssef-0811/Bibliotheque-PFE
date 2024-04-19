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

</head>



<?php
session_start(); // Start the session

// Check if admin is logged in, if not redirect to login page
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: ../../AdminLogin.php");
    exit();
}

// Retrieve admin's name and image URL from session variables
$admin_name = $_SESSION['admin_name'];
// Retrieve admin's image URL from session variable
$admin_image_url = isset($_SESSION['admin_image']) ? $_SESSION['admin_image'] : "images\avatar icon.png"; // Provide a default image URL if admin image is not set

?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
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
            <li class="nav-item ">
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
                <a class="nav-link" href="../Genres/Genre.php">
                    <i class="fas fa-fw fa-swatchbook"></i>
                    <span>Genres</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="../Format/Format.php">
                    <i class="fas fa-fw fa-align-left"></i>
                    <span>Formats</span></a>
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
                        <li class="nav-item dropdown no-arrow" style="margin-right: 10px;">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-lg-inline text-gray-600 "><?php echo $admin_name; ?></span>
                                <!-- <img class="img-profile rounded-circle" src="<?php echo $admin_image_url; ?>"> -->
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../Deconexion.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Deconnexion
                                </a>
                                <a class="dropdown-item" href="../Deconexion.php">
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
                                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-bordered dataTable" id="dataTable" role="grid" aria-describedby="dataTable_info" style="width: 100%;" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">id-client</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">id-emprunt</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">Titre du livre</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">date_d'emprunt</th>
                                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 275.45px;" aria-label="Position: activate to sort column ascending">date de retour</th>
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
                   
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->


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
                                            $sql = "SELECT DISTINCT user.Nom, user.ID,user.Prenom, emprunte_en_attente.id_client FROM user 
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
                                        $stmtc->bind_param('s',$IDclient);
                                        $stmtc->execute();
                                        $resultc = $stmtc->get_result();
                                        $rowc = $resultc->fetch_assoc();
                                           // Extract the count from the result
                                        $rowCount = $rowc['total_rows'];

                                          
?>
                                          <tr>
                                               <td> <?php echo $IDclient ?></td>
                                               <td> <?php  echo $row['Nom']; ?></td>
                                               <td> <?php echo $row['Prenom'];  ?></td>
                                               <td> <?php echo $rowCount; ?> </td>
                                          </tr>
                                        </tbody>
                                        <?php }} ?>
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
function showDeleteModal(Idempr, id_client, Titre, date_emprunt, date_retour,NumeroLivre) {
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
    dataType : "text",
    data: {
        EMPId: Idempr,
        idclient: id_client,
        Titre: Titre,
        dateemp: date_emprunt,
        dateR: date_retour,
        NumL:NumeroLivre
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