<?php
include('DataBase.php');

include('pagination.php');

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
    <title>Document</title>
</head>
<header>
    
    <?php

    include('HF/header2.php')
    ?>
</header><br>

<body>

    <?php
    include('slider.php')
    ?>
<div class="h-divider">
  <div class="shadow"></div>
  <div class="text2"><img src="images/blue book open .jpg" /></div>
</div>



    <div class="cateSear">

        <!--categorie-->

    <div class="selectdiv">
        <form id="categoryForm" action="index.php" method="GET" >
            <label>
                <select name="Categorie" onchange="submitForm()">
                    <option selected> Selectioner Categorie </option>
                    <?php
            // Fetch categories from database
            $sql = "SELECT Nom FROM format";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($ligne = mysqli_fetch_array($result)) {
             echo "<option>".$ligne["Nom"]."</option>";?>
         
                 
<?php           
                }
            }
            ?>
                </select>
            </label>
        </form>
    </div>


 <!--search--> 


<div class="input-container">
<form action="#" method="GET">
  <input type="text" name="search" class="input" placeholder="chercher...">
  <span class="icon">
   <button type="submit" id="searchButton">
    <svg width="19px" height="19px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path opacity="1" d="M14 5H20" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path opacity="1" d="M14 8H17" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M21 11.5C21 16.75 16.75 21 11.5 21C6.25 21 2 16.75 2 11.5C2 6.25 6.25 2 11.5 2" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path> <path opacity="1" d="M22 22L20 20" stroke="#000" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
  
</button></span>
</div>
</form>

</div>
    <script>
    function submitForm() {
        document.getElementById("categoryForm").submit();
    }
</script>
    <br>
    

    <div class="arrivals" id="arrivals">
        
        <h2>Les livres disponibles</h2>
        <div class="arrivals_box">
            <?php
            // Check if search query is set
            if (isset($_GET['search'])  &&  !empty($_GET['search'])) {
                $search = $_GET['search'];
                // search by book title
                $sql = "SELECT livres.*, auteurs.Nom AS Auteur_Nom,genre.Nom AS Genre_Nom 
                FROM livres
                JOIN auteurs ON livres.Auteur_Id = auteurs.Id
                JOIN genre ON livres.Genre_Id = genre.Id
                WHERE livres.Titre LIKE '%$search%'
                OR auteurs.Nom LIKE '%$search%'
                OR genre.Nom LIKE '%$search%'";
                $result = mysqli_query($conn, $sql);
                ?>
                <div class="RechercheResult"><?php echo  "recherche pour : `" . $_GET['search'] . "`"; ?></div>


                <?php
                // Loop through search results and display
                
                while ($ligne = mysqli_fetch_array($result)) { ?>




                    <div class="arrivals_card">
                        <div class="arrivals_image">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']);?>" alt="<?php echo $ligne['Titre'];?>">
                        </div>
                        <div class="arrivals_tag">
                            <p> <?php echo $ligne['Titre']; ?></p>
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
            }
            else if (isset($_GET['Categorie'])) {
                // Check if a category has been selected
                
                    $selected_category = $_GET['Categorie'];

                    $sql = "SELECT * FROM livres 
                    JOIN format on format.Id = livres.Format_Id
                    where format.Nom ='$selected_category'";

                    $result = mysqli_query($conn, $sql);?>
                    
                    <div class="RechercheResult"><?php echo  "Categorie : `" . $_GET['Categorie'] . "`"; ?></div>
                    <?php
                    while ($ligne = mysqli_fetch_array($result)) { ?>


                        <div class="arrivals_card">
                            <div class="arrivals_image">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>"alt="<?php echo $ligne['Titre'];?>">
                            </div>
                            <div class="arrivals_tag">
                                <p> <?php echo $ligne['Titre']; ?></p>
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

                } else {
                $sql = "select * from livres LIMIT  $start, $row_per_page";
                $result = mysqli_query($conn, $sql);

                // If no search query, display all books as before
                while ($ligne = mysqli_fetch_array($result)) { ?>


                    <div class="arrivals_card">
                        <div class="arrivals_image">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>" alt="<?php echo $ligne['Titre'];?>">
                        </div>
                        <div class="arrivals_tag">
                            <p> <?php echo $ligne['Titre']; ?></p>
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
            }
            ?>
        </div>
    </div>



    <div class="page-info">

        <?php
        if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) { ?>
            affiche <?php echo $_GET['page-nr'] ?> sur <?php echo $pages ?>
        <?php } else { ?>
            affiche 1 sur <?php echo $pages ?>
        <?php
        } ?>

    </div>
    <div class="pagination">

        <a class="pagi" href="?page-nr=1#arrivals"><<</a>

        <?php
        if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) {

        ?>

            <a class="pagi" href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>#arrivals">Previous</a>
        <?php
        } else {
        ?>


        <?php

        }


        ?>


  


        <?php

        if (!isset($_GET['page-nr'])) {
        ?>

            <a class="pagi" href="?page-nr=2#arrivals">Next</a>
            <?php
        } else {

            if ($_GET['page-nr'] >= $pages) { ?>



            <?php

            } else {
            ?>
                <a class="pagi" href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>#arrivals">Next</a>

        <?php
            }
        }

        ?>



        <a class="pagi" href="?page-nr=<?php echo $pages ?>#arrivals">>></a>




    </div>









    <?php
    include('HF/footer.php')
    ?>



</body>

</html>