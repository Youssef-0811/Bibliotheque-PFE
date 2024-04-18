
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="header-footer2.css">
<link rel="stylesheet" href="style.css">


    <title>Document</title>
</head>
<body>
    <header>
    <?php 
    
    include("DataBase.php");
include('HF/Header2.php');

?>
</header>





<?php


// Check if the connection is established successfully
$id_client = $_SESSION['ID'];

$sqlcount = "SELECT COUNT(*) AS total_rows FROM empruntconfirme WHERE id_client = ?";
// Prepare the count query
$stmtcount = $conn->prepare($sqlcount);
$stmtcount->bind_param('s', $id_client);
$stmtcount->execute();
$resultcount = $stmtcount->get_result();

    // Define the SQL query
    $sql = "SELECT empruntconfirme.id_client,empruntconfirme.numero_livre_emprunter AS Numero, livres.ISBN AS ISBN, livres.Titre AS Titre, genre.nom AS GenreL, format.Nom AS FormatL, livres.Image AS 'Image' FROM empruntconfirme 
    
    JOIN livres 
    ON empruntconfirme.numero_livre_emprunter = livres.Numero 
    JOIN genre ON livres.Genre_Id = genre.Id
    JOIN format ON livres.Format_Id = format.Id
    WHERE empruntconfirme.id_client = $id_client";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);?>

<h1 id="EP" >Les livres que vous avez emprunter</h1>
<?php
    // Check if the query execution was successful
    if ($result) {
  $rowc = $resultcount->fetch_assoc();
// Extract the count from the result
$rowCount = $rowc['total_rows'];

if ($rowCount === 0) {
    ?>
   <table class="content-table">
<thead>
                <tr>
                   <th>Image</th>
                    <th>ISBN</th>
                    <th>Titre de l'article</th>
                    <th>classe</th>
                    <th colspan="2">Categorie</th>
                    
                </tr>
</thead>
                        
                        <tbody> 
                        <tr>
                           <td></td>
                           <td></td>
                           <td id="noemp">Aucun livre emprunté pour le moment</td>
                           <td></td>
                           <td></td> 
                        </tr>
                    </tbody>
                 
                    </form>
                <?php
                
                ?>

            </table>
            
    <?php
} else {
    ?>


            <table class="content-table">
<thead>
                <tr>
                   <th>Image</th>
                    <th>ISBN</th>
                    <th>Titre de l'article</th>
                    <th>classe</th>
                    <th>Categorie</th>
                    <th></th>
                    
                </tr>
</thead>
                <?php
                while ($ligne = mysqli_fetch_array($result)) {
                ?>
                    
                        
                        <tbody> 
                        <tr>
                        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>" width="70" height="70"></td>
                            <td><?php echo $ligne['ISBN']; ?></td>
                            <td><?php echo $ligne['Titre']; ?></td>
                            <td><?php echo $ligne['GenreL']; ?></td>
                            <td><?php echo $ligne['FormatL']; ?></td>

                            <td><button type="submit" name="submit">Supprimer</button></td>

                            <form action="deletefromemprunt.php" method="post">
                            <input type="hidden" name="Numero" value="<?php echo $ligne['Numero'];  ?>">    
                        </tr>
                    </tbody>
                 
                    </form>
                <?php
                }
                ?>

            </table>
            
        
<?php
}
}




$sqlcountAtt = "SELECT COUNT(*) AS total_rows FROM emprunte_en_attente WHERE id_client = ?";
// Prepare the count query
$stmtcountAtt = $conn->prepare($sqlcountAtt);
$stmtcountAtt->bind_param('s', $id_client);
$stmtcountAtt->execute();
$resultcountAtt = $stmtcountAtt->get_result();

    // Define the SQL query
    $sqlAtt = "SELECT emprunte_en_attente.id_client,emprunte_en_attente.numero_livre_emprunter AS Numero, livres.ISBN AS ISBN, livres.Titre AS Titre, genre.nom AS GenreL, format.Nom AS FormatL, livres.Image AS 'Image' FROM emprunte_en_attente 
    
    JOIN livres 
    ON emprunte_en_attente.numero_livre_emprunter = livres.Numero 
    JOIN genre ON livres.Genre_Id = genre.Id
    JOIN format ON livres.Format_Id = format.Id
    WHERE emprunte_en_attente.id_client = $id_client";

    // Execute the SQL query
    $resultAtt = mysqli_query($conn, $sqlAtt);?>

<h1 id="EP">Les livres en file d'attente</h1>
<?php
    // Check if the query execution was successful
    if ($resultAtt) {
  $rowcAtt = $resultcountAtt->fetch_assoc();
// Extract the count from the result
$rowCountAtt = $rowcAtt['total_rows'];

if ($rowCountAtt === 0) {
    ?>
   <table class="content-table">
<thead>
                <tr>
                <th>Image</th>
                    <th>ISBN</th>
                    <th>Titre de l'article</th>
                    <th>classe</th>
                    <th>Categorie</th>
                    <th></th>
                </tr>
</thead>
                        
                        <tbody> 
                        <tr>
                           <td></td>
                           <td></td>
                           <td id="noemp">Aucun livre en attente pour le moment</td>
                           <td></td>
                           <td></td> 
                           <td></td>
                        </tr>
                    </tbody>
                 
                    </form>
                <?php
                
                ?>

            </table>
            
    <?php
} else {
    ?>


            <table class="content-table">
<thead>
                <tr>
                <th>Image</th>
                    <th>ISBN</th>
                    <th>Titre de l'article</th>
                    <th>classe</th>
                    <th>Categorie</th>
                    <th></th>
                </tr>
</thead>
                <?php
                while ($ligne = mysqli_fetch_array($resultAtt)) {
                ?>
                    <form action="deletefromfileattente.php" method="post">
                        
                        <tbody> 
                        <tr>
                        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>" width="70" height="70"></td>
                            <td><?php echo $ligne['ISBN']; ?></td>
                            <td><?php echo $ligne['Titre']; ?></td>
                            <td><?php echo $ligne['GenreL']; ?></td>
                            <td><?php echo $ligne['FormatL']; ?></td>
                            <td><button type="submit" name="submit">Supprimer</button></td>

                            <form action="deletefromfileattente.php" method="post">
                            <input type="hidden" name="Numero" value="<?php echo $ligne['Numero'];  ?>">

                        </tr>
                    </tbody>
                 
                    </form>
                <?php
                }
                ?>

            </table>
            
        
<?php
}
}
?>



<div class="livres">

<?php
$queryLiv = "SELECT * FROM livres 
 EXCEPT SELECT * FROM livres WHERE Numero = 10 ";
$resultLiv = mysqli_query($conn,$queryLiv);
?>
<h2>livres</h2>
<div class="arrivals_box">
    <?php while ($ligne = mysqli_fetch_array($resultLiv)) { ?>
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
    <?php } ?>
</div>
<a href="accueil.php"><button >Retour</button></a>
</body>
</html>