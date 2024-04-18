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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">

    <?php

    session_start(); // Start the session
    include("../DataBase.php");


    // Function to execute a query
    function executeQuery($query)
    {
        global $conn;
        return mysqli_query($conn, $query);
    }

    // Function to fetch data from a result set
    function fetchData($result)
    {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
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
    // Evolution of books added over the last week
    $query_weekly_books_added = "SELECT DATE_FORMAT(Parution, '%Y-%m-%d') AS date_added, COUNT(*) AS books_added 
                            FROM livres 
                            WHERE Parution >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
                            GROUP BY DATE_FORMAT(Parution, '%Y-%m-%d')";
    $result_weekly_books_added = executeQuery($query_weekly_books_added);
    $data_weekly_books_added = fetchData($result_weekly_books_added);

    // Evolution of books added over the last month
    $query_monthly_books_added = "SELECT DATE_FORMAT(Parution, '%Y-%m-%d') AS date_added, COUNT(*) AS books_added 
                            FROM livres 
                            WHERE Parution >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                            GROUP BY DATE_FORMAT(Parution, '%Y-%m-%d')";
    $result_monthly_books_added = executeQuery($query_monthly_books_added);
    $data_monthly_books_added = fetchData($result_monthly_books_added);

    // Evolution of books added over the last year
    $query_yearly_books_added = "SELECT DATE_FORMAT(Parution, '%Y-%m') AS month_year, COUNT(*) AS books_added 
                            FROM livres 
                            WHERE Parution >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                            GROUP BY DATE_FORMAT(Parution, '%Y-%m')";
    $result_yearly_books_added = executeQuery($query_yearly_books_added);
    $data_yearly_books_added = fetchData($result_yearly_books_added);

    // Combine data for all periods
    $combined_labels = array_merge(
        array_column($data_weekly_books_added, 'date_added'),
        array_column($data_monthly_books_added, 'date_added'),
        array_column($data_yearly_books_added, 'month_year')
    );
    $combined_data = array_merge(
        array_column($data_weekly_books_added, 'books_added'),
        array_column($data_monthly_books_added, 'books_added'),
        array_column($data_yearly_books_added, 'books_added')
    );
    // Total number of books
    $query_total_books = "SELECT COUNT(*) AS total_books FROM livres";
    $result_total_books = mysqli_query($conn, $query_total_books);
    $row_total_books = mysqli_fetch_assoc($result_total_books);
    $total_books = $row_total_books['total_books'];

    // Evolution of books added over time (Monthly)
    $query_books_added_evolution = "SELECT DATE_FORMAT(Parution, '%Y-%m') AS month_year, COUNT(*) AS books_added 
                                FROM livres 
                                GROUP BY DATE_FORMAT(Parution, '%Y-%m')";
    $result_books_added_evolution = mysqli_query($conn, $query_books_added_evolution);

    // Fetching data for the chart
    $chart_labels = [];
    $chart_data = [];

    while ($row = mysqli_fetch_assoc($result_books_added_evolution)) {
        $chart_labels[] = $row['month_year'];
        $chart_data[] = $row['books_added'];
    }

    // Number of books borrowed
    $query_books_borrowed = "SELECT COUNT(*) AS books_borrowed FROM empruntconfirme";
    $result_books_borrowed = mysqli_query($conn, $query_books_borrowed);
    $row_books_borrowed = mysqli_fetch_assoc($result_books_borrowed);
    $books_borrowed = $row_books_borrowed['books_borrowed'];

    // Top users who borrowed the most books
    $query_top_users = "SELECT u.Nom, u.Prenom, COUNT(le.numero_livre_emprunter) AS books_borrowed_count
                    FROM user u
                    JOIN empruntconfirme le ON u.ID = le.id_client
                    GROUP BY u.ID
                    ORDER BY books_borrowed_count DESC
                    LIMIT 3";
    $result_top_users = mysqli_query($conn, $query_top_users);

    // Top three genres
    $query_top_genres = "SELECT g.nom AS genre, COUNT(l.Numero) AS books_count
                     FROM livres l
                     JOIN genre g ON l.Genre_Id = g.Id
                     GROUP BY g.Id
                     ORDER BY books_count DESC
                     LIMIT 3";
    $result_top_genres = mysqli_query($conn, $query_top_genres);

    // Most borrowed format
    $query_most_borrowed_format = "SELECT f.Nom AS format, COUNT(l.Numero) AS books_count
                                FROM livres l
                                JOIN format f ON l.Format_Id = f.Id
                                GROUP BY f.Id
                                ORDER BY books_count DESC
                                LIMIT 1";
    $result_most_borrowed_format = mysqli_query($conn, $query_most_borrowed_format);
    $row_most_borrowed_format = mysqli_fetch_assoc($result_most_borrowed_format);
    $most_borrowed_format = $row_most_borrowed_format['format'];

    // Least borrowed format
    $query_least_borrowed_format = "SELECT f.Nom AS format, COUNT(l.Numero) AS books_count
                                FROM livres l
                                JOIN format f ON l.Format_Id = f.Id
                                GROUP BY f.Id
                                ORDER BY books_count ASC
                                LIMIT 1";
    $result_least_borrowed_format = mysqli_query($conn, $query_least_borrowed_format);
    $row_least_borrowed_format = mysqli_fetch_assoc($result_least_borrowed_format);
    $least_borrowed_format = $row_least_borrowed_format['format'];

    // Most popular authors
    $query_most_popular_authors = "SELECT a.Nom AS author_name, COUNT(l.Numero) AS books_count
                                FROM auteurs a
                                JOIN livres l ON a.ID = l.Auteur_Id
                                GROUP BY a.ID
                                ORDER BY books_count DESC
                                LIMIT 3";
    $result_most_popular_authors = mysqli_query($conn, $query_most_popular_authors);

    // Close database connection
    mysqli_close($conn);
    ?>
    <style>
        /* Custom CSS styles can be added here */
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

        .footer {
            text-align: center;
            padding: 1rem 0;
            background-color: #f8f9fc;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
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
                <div class="sidebar-brand-text mx-1">Webook</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../Admin/AdminDash.php">
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
                <a class="nav-link" href="../Admin/Livres/Book.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Livres</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Admin/Auteurs/Auteur.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Auteurs</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Admin/Genres/Genre.php">
                    <i class="fas fa-fw fa-swatchbook"></i>
                    <span>Genres</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Admin/Format/Format.php">
                    <i class="fas fa-fw fa-align-left"></i>
                    <span>Formats</span></a>
            </li>
        </ul>
        <!-- End of Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
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
                                <a class="dropdown-item" href="Deconexion.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Deconnexion
                                </a>
                                <a class="dropdown-item" href="./compte.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Compte
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- End of Topbar -->
                <div class="container-fluid">
                    <!-- Total number of books and Number of books borrowed -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Number of Books</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_books ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Number of Books Borrowed</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $books_borrowed ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Evolution of books added over time -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Evolution of Books Added Over Time</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="booksAddedChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top users who borrowed the most books -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Top Users Who Borrowed the Most Books</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Number of Books Borrowed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_assoc($result_top_users)) { ?>
                                                    <tr>
                                                        <td><?= $row['Nom'] . ' ' . $row['Prenom'] ?></td>
                                                        <td><?= $row['books_borrowed_count'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top three genres and Most and least borrowed formats -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Top Three Genres</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <?php while ($row = mysqli_fetch_assoc($result_top_genres)) { ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <?= $row['genre'] ?>
                                                <span class="badge badge-primary badge-pill"><?= $row['books_count'] ?></span>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Most and Least Borrowed Formats</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Most Borrowed Format
                                            <span class="badge badge-primary badge-pill"><?= $most_borrowed_format ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Least Borrowed Format
                                            <span class="badge badge-primary badge-pill"><?= $least_borrowed_format ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Most popular authors -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Most Popular Authors</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <?php while ($row = mysqli_fetch_assoc($result_most_popular_authors)) { ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <?= $row['author_name'] ?>
                                                <span class="badge badge-primary badge-pill"><?= $row['books_count'] ?></span>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End of Footer -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- Custom script for this page -->
    <script>
        // Chart.js for evolution of books added over time
        var ctx = document.getElementById('booksAddedChart').getContext('2d');
        var booksAddedChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($chart_labels) ?>,
                datasets: [{
                    label: 'Books Added Over Time',
                    data: <?= json_encode($chart_data) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Number of Books Added'
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>