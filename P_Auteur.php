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
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script for "Read More" functionality -->
    <script>
        $(document).ready(function() {
            // Handle "Read More" click event
            $('.biography').on('click', 'a', function(e) {
                e.preventDefault(); // Prevent default link behavior
                $(this).parent().html('<?php echo $row['Bio']; ?>'); // Display full biography
            });
        });
    </script>
    <script>
        // Function to open the edit modal
        function openEditModal() {
            var modal = document.getElementById("editModal");
            modal.style.display = "block";
        }

        // Function to close the edit modal
        window.onclick = function(event) {
            var modal = document.getElementById("editModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // You would also need JavaScript to handle form submission and populate form fields with existing data.

        function editAuthor(id, nom, prenom, dateNaissance, bio) {
            // Set the values in the modal form fields
            $('#authorId').val(id);
            $('#nom').val(nom);
            $('#prenom').val(prenom);
            $('#dateNaissance').val(dateNaissance);
            $('#bio').val(bio);

            // Show the modal
            $('#editModal').modal('show');
        }
    </script>


</head>

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
                <a class="nav-link" href="index.html">
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
            <li class="nav-item">
                <a class="nav-link" href="Book.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Livres</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="Auteur.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Auteurs</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Genre.php">
                    <i class="fas fa-fw fa-swatchbook"></i>
                    <span>Genres</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Format.php">
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
                                <h1 class="h3 text-gray-800">Auteurs</h1>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="https://www.linkedin.com/in/aude-velly-menut/" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-lg-inline text-gray-600 small">Aude Velly Menut</span>
                                <img class="img-profile rounded-circle" src="https://media.licdn.com/dms/image/C4E03AQFiMuNDUqxhVQ/profile-displayphoto-shrink_100_100/0?e=1564617600&v=beta&t=NEstICqg4IbD-Kczp066VDKb9VpMGa7gJ_fmRm6FLU4">
                            </a>

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
                            <div class="table-responsive <?php include("DataBase.php");

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
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Biographie</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Date de naissance</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 125.45px;" aria-label="Position: activate to sort column ascending">Edit or Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody id="authors">
                                        <?php
                                        // Inclure le fichier FetchA.php pour obtenir les données des auteurs
                                        include("FetchA.php");

                                        // Vérifier si $result est défini et non vide
                                        if ($result && $result->num_rows > 0) {
                                            // Boucle à travers les résultats pour afficher chaque auteur dans une ligne de tableau
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $row['Nom']; ?></td>
                                                    <td><?php echo $row['Prenom']; ?></td>
                                                    <td><?php echo $row['DateNaissance']; ?></td>
                                                    <td>
                                                        <!-- Lien d'édition avec l'ID de l'auteur -->
                                                        <a href="EditAuteur.php">open</a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            // Aucun résultat trouvé
                                            echo "<tr><td colspan='6'>Aucun auteur trouvé.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>















                <div class="card border-left-primary shadow mb-4">
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

</body>

</html>