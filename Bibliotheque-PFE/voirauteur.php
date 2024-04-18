<?php include('DataBase.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitauteur'])) {


$id_auteur = $_POST['idauteur'];


$sql = "SELECT * FROM auteurs Where id =  $id_auteur ";

$result = mysqli_query($conn,$sql);

$ligne = mysqli_fetch_assoc($result);
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

<!--GOOGLE FONTS-->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Play&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="header-footer2.css">
    <title>Document</title>
</head>


<header>
    <?php
    include('HF/header2.php');?>
</header>


<body>
<?php if ( $result && mysqli_num_rows($result) > 0) {?>

<div class="image">
    
<img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>">
<div class="info">
<P>Nom:  <?php echo $ligne['Nom'];?> </P>
<p>Prenom:  <?php echo $ligne['Prenom'];?></p>
<p>age:  <?php echo $ligne['DateNaissance'];?></p>
<p>Nationalite: Marrocain</p>
</div>

  </div>

<div class="desc">
<div class="description">
<h1>Description</h1>

<p>
Biographie courte de Mark Twain - Samuel Langhorne Clemens, plus connu sous le nom de Mark Twain, est un écrivain et humoriste américain né le 30 novembre 1835 à Florida aux États-Unis. Son père décède alors qu'il n'a que 12 ans. Pour subsister aux besoins de la famille, le jeune Clemens abandonne ses études et devient apprenti typographe dans l'imprimerie du village. En 1850, il rejoint le journal fondé par son frère et rédige ses premiers articles. Alors qu'il vient d'embarquer sur le Mississippi pour se rendre à La Nouvelle-Orléans, le jeune homme rencontre un capitaine de bateau à vapeur nommé Horace E. Bixby, lequel parvient à le convaincre de travailler pour lui. De cette rencontre naîtra son pseudonyme : lorsqu'il vérifie la profondeur du fleuve, le capitaine lui crie "mark twain !", des mots de jargon pour signaler que la profondeur est suffisante.

En 1864, Mark Twain travaille à San Francisco en tant que reporter et voyage régulièrement en Europe. Cinq ans plus tard, il publie son premier roman, Le Voyage des innocents, dans lequel il s'inspire de ses voyages, suivi de À la dure ! en 1872. Mais c'est grâce à son roman Les Aventures de Tom Sawyer, publié en 1876 que l'écrivain connaît la célébrité. Ses qualités de romancier se confirment à la publication de la suite, Les Aventures de Huckleberry Finn, en 1885. Mark Twain se caractérise par la précision de ses descriptions, démontrant à quel point il s'imprègne des lieux qu'il traverse. Grâce à son expérience et à ses voyages, il parvient à décrire la société américaine d'un point de vue inhabituel pour son époque. Il décède d'une crise cardiaque le 21 avril 1910 à Redding (États-Unis) à l'âge de 74 ans. Il venait de perdre successivement sa femme et deux de ses trois filles.
</p>
</div>
</div>

<?php } ?>


<div class="livres">

<?php
$queryLiv = "SELECT * FROM livres;";
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



<div class="livres">

<?php
$queryLiv = "select * from livres;";
$resultLiv = mysqli_query($conn,$queryLiv);
?>
        <h2>livres de meme genre</h2>
        <div class="arrivals_box">
            <?php while ($ligne = mysqli_fetch_array($resultLiv)) {
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




</body>
<?php
include('HF/footer.php');
?>

</html>