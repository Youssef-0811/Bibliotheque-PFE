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
            <div class="txt">
                <h1>Bonjour dans Bibliotheque Online</h1>
                <h4>Emprunter Maintenant</h4>
                <div class="buttn">
                    <a href="index.php"><button id="btn">Emprunter</button></a>
                </div>
            </div>
        </div>
    </div>
    <br>






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


    <div class="arrivals">
        <h2>nouveaux livres</h2>
        <div class="arrivals_box">

            <?php while ($ligne = mysqli_fetch_array($result)) {

            ?>


                <div class="arrivals_card">
                    <div class="arrivals_image">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>">
                    </div>
                    <div class="arrivals_tag">
                        <p> <?php echo $ligne['Titre']; ?> </p>
                        <div class="arrivals_icon">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                        
                        <form action="page-info.php" method="post">
                  <input class="arrivals_btn" type="submit" name="submitLiv" value="Savoir plus">
                <input type="hidden" name="id-livre" value=" <?php echo $ligne['Numero']; ?>">

                </form>

                    </div>
                </div>
            <?php
            }
            ?>
        </div>
</div>

<div class="arrivals">
        <h2>Auteurs</h2>
        <div class="arrivals_box">

            <?php while ($ligne = mysqli_fetch_array($resulta)) {

            ?>


                <div class="arrivals_card">
                    <div class="arrivals_image">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>">
                    </div>
                    <div class="arrivals_tag">
                        <p> <?php echo $ligne['Nom']; 
                        echo $ligne['Prenom']; ?> </p>

                        <form action="voirauteur.php" method="post">

                        <input type="hidden" name="idauteur" value="<?php echo $ligne['Id']; ?>">


                        <input class="arrivals_btn" type="submit" name="submitauteur" value="Savoir plus">
                        </form>

            

                    </div>
                </div>
            <?php
            }
            ?>
        </div>
</div>
</body>
<?php
include('HF/footer.php')
?>