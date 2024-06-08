<?php

include('DataBase.php');



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Play&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/footer.css"> -->
    <link rel="stylesheet" href="acueil.css">
    <link rel="stylesheet" href="header-footer2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <title>Document</title>

</head>

<header>
    <?php
    include('HF/header2.php'); ?>
</header>

<?php
//importer les 8 derniers livres dans la base
$row_per_page = 8;

$sql0 = 'select * from livres';
$records = mysqli_query($conn, $sql0);

$nr_of_rows = mysqli_num_rows($records);

$pages = ceil($nr_of_rows / $row_per_page);

$start = max(0, $nr_of_rows - 8);
$sql = "SELECT * FROM livres LIMIT $start, $row_per_page";
$result = mysqli_query($conn, $sql);

//importer les 8 derniers auteurs dans la base

$sqlat =  "SELECT * FROM auteurs";
$recordsa = mysqli_query($conn, $sqlat);
$nr_of_rowsa = mysqli_num_rows($recordsa);
$starta = max(0, $nr_of_rowsa - 8);

$sqla = "SELECT * FROM auteurs LIMIT $starta, $row_per_page";
$resulta = mysqli_query($conn, $sqla);
?>

<body>
    <div class="container">

        <div class="emp">
            <img src="images/vector.jpg" alt="">
        </div>


        <div class="txt">
            <div>
                <h1 class="main-heading">
                    DÉCOUVREZ LE MONDE DU SAVOIR DANS NOTRE BIBLIOTHÈQUE
                </h1>
                <p class="sub-heading">
                    EXPLOREZ NOTRE VASTE COLLECTION DE LIVRES, REVUES ET ARCHIVES NUMÉRIQUES, ET IMMERGEZ-VOUS DANS LA RICHE TAPISSERIE DE LITTERATURE ET DE CONNAISSANCES.
                </p>
                <div class="button-container">
                    <a class="explore-button" href="#">
                        Explore Library
                    </a>
                    <a class="join-button" href="#">
                        Join Now
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="separator">
        <svg class="separator__svg" width="100%" height="350" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="myGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="10%" style="stop-color: rgba(0,108,3,1); stop-opacity: 1;" />
                    <stop offset="30%" style="stop-color: rgba(24,121,9,1); stop-opacity: 1;" />
                    <stop offset="100%" style="stop-color: rgba(255,255,255,1); stop-opacity: 1;" />
                </linearGradient>
            </defs>
            <path d="M 100 100 V 10 L 0 100" fill="url(#myGradient)" />
            <path d="M 30 73 L 100 18 V 10 Z" fill="#308355" stroke-width="0" />
        </svg>







        <!--Services-->


        <div class="services">

            <div class="services_box">

                <div class="services_card">

                    <h3>Emprunter des livres</h3>
                    <p>
                        Emprunter jusqua 4 livres au maximum
                    </p>
                </div>

                <div class="services_card">

                    <h3>Biographie d'auteur</h3>
                    <p>
                        possibilite de lire la Biographie de vos auteurs preferes
                    </p>
                </div>

                <div class="services_card">

                    <h3>les commentaire </h3>
                    <p>
                        voir les commentaires des personnes sur les livres
                    </p>
                </div>

                <div class="services_card">

                    <h3>compte</h3>
                    <p>
                        Creez vote propre compte
                    </p>
                </div>

            </div>

        </div>


        <!--About-->

        <div class="about">

            <div class="about_image">
                <img src="images/about.png">
            </div>
            <div class="about_tag">
                <h1>Apropos de nous</h1>
                <p>
                    <b>Bienvenue à la Bibliothèque online</b> <br>

                    Dans un coin paisible de la ville, se trouve un lieu enchanté où les mots prennent vie et les esprits s'évadent : la <b>Bibliothèque ONLINE</b>. Au cœur de cette oasis littéraire, un service d'emprunt de livres vous attend, ouvert à tous les avides de découvertes et de voyages au-delà des pages.

                    Plongez dans un monde de possibilités infinies où chaque rayonnage recèle des trésors à découvrir. Notre système d'emprunt simple et convivial vous permet de choisir parmi une vaste sélection d'œuvres, des classiques intemporels aux nouveautés palpitantes.

                    Comment ça fonctionne ? C'est facile ! Il vous suffit de vous inscrire en tant que membre, et le monde des mots s'ouvre à vous. Parcourez les étagères, laissez-vous envoûter par les résumés alléchants et les couvertures intrigantes, puis sélectionnez les joyaux littéraires qui vous appellent.

                    Une fois votre choix fait, présentez-vous au comptoir de prêt, où notre équipe chaleureuse et compétente vous accueillera avec le sourire. Ils vous aideront à finaliser votre emprunt et répondront à toutes vos questions avec plaisir.

                    Que vous soyez un voyageur chevronné à travers les mondes imaginaires, un explorateur des mystères du passé ou un aventurier à la recherche de connaissances nouvelles,<b>La Bibliothèque ONLINE</b> est votre partenaire idéal dans cette quête infinie de savoir et de divertissement.

                    Rejoignez-nous dès aujourd'hui et laissez-vous emporter par la magie des livres à la <b>Bibliothèque ONLINE</b> .
                </p>
                <a href="#" class="about_btn">Learn More</a>
            </div>

        </div>


        <div class="arrivals py-8">
            <h2 class="text-2xl font-bold text-center mb-8">Nos meilleurs livres</h2>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php while ($ligne = mysqli_fetch_array($result)) { ?>
                    <div class="card bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                        <div class="relative h-64 overflow-hidden rounded-t-lg">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>" alt="Book cover" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <h3 class="title1"><?php echo $ligne['Titre']; ?></h3>
                                <p class="category1"><?php echo $ligne['Format_Id']; ?></p>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="resume1">
                                <?php echo $ligne['Resume']; ?>
                            </p>
                            <form action="page-info.php" method="post" class="form1">
                                <input type="hidden" name="id-livre" value="<?php echo $ligne['Numero']; ?>">
                                <button type="submit" name="submitLiv" class="button1">
                                    Savoir plus
                                </button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>



        <div class="arrivals2">
            <h2>Auteurs</h2>
            <div class="arrivals_box grid">
                <?php while ($ligne = mysqli_fetch_array($resulta)) { ?>
                    <div class="author-card2">
                        <div class="author-info">
                            <div class="avatar2">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>">
                            </div>
                            <div class="author-name-bio">
                                <h3 class="author-name2"><?php echo $ligne['Nom'] . ' ' . $ligne['Prenom']; ?></h3>
                                <p class="author-bio2"><?php echo strlen($ligne['Bio']) > 35 ? substr($ligne['Bio'], 0, 35) . '...' : $ligne['Bio']; ?></p>
                            </div>
                        </div>
                        <div class="author-actions">
                            <form action="testpage.php" method="post">
                                <input type="hidden" name="idauteur" value="<?php echo $ligne['Id']; ?>">
                                <input class="button2" type="submit" name="submitauteur" value="Savoir plus">
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>







        <script>
            $(document).ready(function() {
                // Handle button click event for marking notification as read
                $(".mark-as-read").click(function() {
                    var notificationId = $(this).data("notification-id");

                    // AJAX request to update notification status to 'read'
                    $.ajax({
                        type: "POST",
                        url: "mark_notification_as_read.php", // Replace with the URL of your PHP script to handle the update
                        data: {
                            notification_id: notificationId
                        },
                        success: function(response) {
                            // Update UI or perform other actions if needed
                            console.log("Notification marked as read.");
                            // Hide the notification after marking it as read
                            $(this).prev(".notification").hide();
                            $(this).hide();
                        },
                        error: function(xhr, status, error) {
                            // Handle AJAX errors
                            console.error("AJAX Error: " + error);
                        }
                    });
                });
            });
        </script>
</body>
<?php
include('HF/footer.php')
?>