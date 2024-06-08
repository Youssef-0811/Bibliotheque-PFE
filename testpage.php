<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="header-footer2.css">
    <title>Document</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            padding: 24px;
        }

        .profile-image {
            flex-shrink: 0;
            border-radius: 50%;
            overflow: hidden;
            width: 128px;
            height: 128px;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-details {
            flex: 1;
            display: grid;
            gap: 16px;
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-info svg {
            width: 30px;
            height: 30px;
        }

        .bio-section,
        .books {
            background-color: #f3f4f6;
            padding: 32px;
            border-radius: 8px;
            width: 1200px;
        }

        .bio-section h2,
        .books-section h2 {
            font-size: 24px;
            margin-bottom: 16px;
        }

        .book-card {
            background-color: #f3f4f6;
            padding: 16px;
            border-radius: 8px;
            text-align: center;
            min-width: 200px;
            flex: 0 0 auto;
            border: 1px solid #ccc;
            /* Added border */
        }

        .book-card img {
            width: 180px;
            height: 280px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .books-section {
            display: flex;
            overflow-x: auto;
            gap: 16px;
        }

        .books-grid {
            display: flex;
            gap: 16px;
        }

        .noBook {
            color: #ff0000;
            /* Red color */
            font-size: 18px;
            /* Font size */
            font-style: italic;
            /* Italic font style */
            text-align: center;
            /* Center alignment */
        }
    </style>
</head>

<body>

    <header>
        <?php include('./HF/Header2.php');
        ?>
    </header>
    <?php include('DataBase.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitauteur'])) {


        $id_auteur = $_POST['idauteur'];


        $sql = "SELECT * FROM auteurs Where id =  $id_auteur ";

        $result = mysqli_query($conn, $sql);

        $ligne = mysqli_fetch_assoc($result);
    } ?>

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
    <div class="container">
        <!-- <?php if ($result && mysqli_num_rows($result) > 0) { ?>
    <div class="profile-image">
    <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>">
    </div> -->
        <div class="profile-details">
            <div class="profile-header">



                <h1 style="font-size: 24px; font-weight: bold;"><?php echo $ligne['Nom']; ?></h1>
                <p style="color: #6b7280;">auteur</p>
                <div class="profile-info">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                        <path d="M3 10h18"></path>
                        <path d="M8 14h.01"></path>
                        <path d="M12 14h.01"></path>
                        <path d="M16 14h.01"></path>
                        <path d="M8 18h.01"></path>
                        <path d="M12 18h.01"></path>
                        <path d="M16 18h.01"></path>
                    </svg>
                    <span>Date de naissance: <?php echo $ligne['DateNaissance']; ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
                        <line x1="4" x2="4" y1="22" y2="15"></line>
                    </svg>
                    <span>Nationality: American</span>
                </div>
            </div>


            <div class="bio-section">
                <h2>Biography</h2>
                <div>
                    Biographie courte de Mark Twain - Samuel Langhorne Clemens, plus connu sous le nom de Mark Twain, est un écrivain et humoriste américain né le 30 novembre 1835 à Florida aux États-Unis. Son père décède alors qu'il n'a que 12 ans. Pour subsister aux besoins de la famille, le jeune Clemens abandonne ses études et devient apprenti typographe dans l'imprimerie du village. En 1850, il rejoint le journal fondé par son frère et rédige ses premiers articles. Alors qu'il vient d'embarquer sur le Mississippi pour se rendre à La Nouvelle-Orléans, le jeune homme rencontre un capitaine de bateau à vapeur nommé Horace E. Bixby, lequel parvient à le convaincre de travailler pour lui. De cette rencontre naîtra son pseudonyme : lorsqu'il vérifie la profondeur du fleuve, le capitaine lui crie "mark twain !", des mots de jargon pour signaler que la profondeur est suffisante.

                    En 1864, Mark Twain travaille à San Francisco en tant que reporter et voyage régulièrement en Europe. Cinq ans plus tard, il publie son premier roman, Le Voyage des innocents, dans lequel il s'inspire de ses voyages, suivi de À la dure ! en 1872. Mais c'est grâce à son roman Les Aventures de Tom Sawyer, publié en 1876 que l'écrivain connaît la célébrité. Ses qualités de romancier se confirment à la publication de la suite, Les Aventures de Huckleberry Finn, en 1885. Mark Twain se caractérise par la précision de ses descriptions, démontrant à quel point il s'imprègne des lieux qu'il traverse. Grâce à son expérience et à ses voyages, il parvient à décrire la société américaine d'un point de vue inhabituel pour son époque. Il décède d'une crise cardiaque le 21 avril 1910 à Redding (États-Unis) à l'âge de 74 ans. Il venait de perdre successivement sa femme et deux de ses trois filles.
                </div>
            <?php }  ?>
            </div>
            <div class="books">
                <h2>Livres pour ce auteur</h2>
                <div class="books-section">
                    <?php
                    $queryLiv = "SELECT livres.Titre, livres.Image, livres.Numero 
        FROM livres 
        JOIN auteurs 
        ON livres.Auteur_Id = auteurs.id 
        WHERE auteurs.id = $id_auteur; ";

                    $resultLiv = mysqli_query($conn, $queryLiv); ?>

                    <div class="books-grid">
                        <?php if (mysqli_num_rows($resultLiv) > 0) { ?>

                            <?php while ($ligne = mysqli_fetch_array($resultLiv)) { ?>
                                <div class="book-card">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>">
                                    <h3><?php echo $ligne['Titre']; ?></h3>
                                    <form action="page-info.php" method="post">
                                        <input class="arrivals_btn" type="submit" name="submitLiv" value="Savoir plus">
                                        <input type="hidden" name="id-livre" value=" <?php echo $ligne['Numero']; ?>">
                                    </form>
                                </div>
                            <?php } ?>



                        <?php
                        } else { ?>
                            <div class="book-card">
                                <!-- // Display a message if there are no books -->
                                <?php echo "<p class='noBook'>No books found for this author.</p>"; ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <!-- x -->

            <div class="books">
                <h2>Livres recommander</h2>
                <div class="books-section">
                    <?php
                    $queryLiv = "SELECT * FROM livres Limit 8;";
                    $resultLiv = mysqli_query($conn, $queryLiv);
                    ?>

                    <div class="books-grid">
                        <?php while ($ligne = mysqli_fetch_array($resultLiv)) { ?>
                            <div class="book-card">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>">
                                <h3><?php echo $ligne['Titre']; ?></h3>
                                <form action="page-info.php" method="post">
                                    <input class="arrivals_btn" type="submit" name="submitLiv" value="Savoir plus">
                                    <input type="hidden" name="id-livre" value=" <?php echo $ligne['Numero']; ?>">
                                </form>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>