<?php
include('DataBase.php');


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitLiv'])) {


    $id_livre = mysqli_real_escape_string($conn, $_POST['id-livre']);


$sql = "SELECT * FROM livres WHERE Numero = $id_livre ";

$result = mysqli_query($conn,$sql);

$ligne = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header-footer2.css">
    <title>Document</title>
</head>
<header>
<?php
include('HF/header2.php');

?>
</header>
<body>

<style>

body{
  font-family: Noto Sans, sans-serif;
}

.main{
margin: 0 80px;
}

.card {
  position: relative;
  margin-top: 10rem;
}

.card img {
  border-radius: 10px;
  width: 450px;
  height: 600px;
  fill: #333;
  transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  box-shadow: 0 0 15px rgb(76, 44, 0);
}





.emprunt{
    right: 5rem;
    position: absolute;
    top: 10rem;
    float: left;
    width: 50%;

}
.emprunt h1{
font-size: 70px;

}

.main #submit{
margin-top: 1rem;
width: 20rem;
 align-items: center;
 appearance: none;
 background-color: rgb(76, 44, 0);
 border-radius: 35px;
 border-width: 0;
 box-shadow: rgba(45, 35, 66, 0.2) 0 2px 4px,rgba(45, 35, 66, 0.15) 0 7px 13px -3px,#D6D6E7 0 -3px 0 inset;
 box-sizing: border-box;
 color: white;
 cursor: pointer;
 display: inline-flex;
 font-family: "JetBrains Mono",monospace;
 height: 48px;
 justify-content: center;
 line-height: 1;
 list-style: none;
 overflow: hidden;
 padding-left: 10px;
 padding-right: 10px;
 position: relative;
 text-align: left;
 text-decoration: none;
 transition: box-shadow .15s,transform .15s;
 user-select: none;
 -webkit-user-select: none;
 touch-action: manipulation;
 white-space: nowrap;
 will-change: box-shadow,transform;
 font-size: 15px;
}

.main #submit:focus {
 box-shadow: #D6D6E7 0 0 0 1.5px inset, rgba(45, 35, 66, 0.4) 0 2px 4px, rgba(45, 35, 66, 0.3) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
}

.main #submit:hover {
 box-shadow: rgba(45, 35, 66, 0.3) 0 4px 8px, rgba(45, 35, 66, 0.2) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
 transform: translateY(-2px);
}

.main #submit:active {
 box-shadow: #D6D6E7 0 3px 7px inset;
 transform: translateY(2px);
}


#Etat,#DateR{
font-size: 35px;
  margin-top: 3rem;
}
.details{
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
  border-radius: 10px;
}
.details .cont{
margin-left: 30px;

}
.details .cont .roz{
  display: grid;
    grid-template-columns: 1fr 1fr;
    margin-top: 2rem;
    align-items: center;
    grid-template-columns: 10rem max-content;
  }
  .cont h2{
    padding-top: 0.5rem;
  }

</style>


<div class="main">
  
<?php if ($result && mysqli_num_rows($result) > 0) {?>

    <div class="card">
  <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>">

    </div>



<div class="emprunt">
     <h1><?php echo $ligne['Titre'];?></h1><br>
    <h3>Resume</h3>
    <p>Dans un coin paisible de la ville, se trouve un lieu enchanté où les mots prennent vie et les esprits s'évadent : la <b>Bibliothèque ONLINE</b>. Au cœur de cette oasis littéraire, un service d'emprunt de livres vous attend, ouvert à tous les avides de découvertes et de voyages au-delà des pages.

Plongez dans un monde de possibilités infinies où chaque rayonnage recèle des trésors à découvrir. Notre système d'emprunt simple et convivial vous permet de choisir parmi une vaste sélection d'œuvres, des classiques intemporels aux nouveautés palpitantes.

Comment ça fonctionne ? C'est facile ! Il vous suffit de vous inscrire en tant que membre, et le monde des mots s'ouvre à vous. Parcourez les étagères, laissez-vous envoûter par les résumés alléchants et les couvertures intrigantes, puis sélectionnez les joyaux littéraires qui vous appellent.

Une fois votre choix fait, présentez-vous au comptoir de prêt, où notre équipe chaleureuse et compétente vous accueillera avec le sourire. Ils vous aideront à finaliser votre emprunt et répondront à toutes vos questions avec plaisir.

Que vous soyez un voyageur chevronné à travers les mondes imaginaires, un explorateur des mystères du passé ou un aventurier à la recherche de connaissances nouvelles,<b>La Bibliothèque ONLINE</b> est votre partenaire idéal dans cette quête infinie de savoir et de divertissement.

Rejoignez-nous dès aujourd'hui et laissez-vous emporter par la magie des livres à la  <b>Bibliothèque ONLINE</b></p>
 
</div>
<div class="details">
  <div class="cont">  
 <h2>Détails du produit</h2> 
<hr width="80%">
<div class="roz">
  <label for="Etat">Etat:</label>
  <p>disponible</p>
 <label for="nomlivre"><b>Nom de livre:</b></label>
 <p><?php echo $ligne['Titre'];?></p>
 <label for="nomauteur"><b>Nom d'auteur:</b></label>
 <p>Auteur</p>
 </div>
</div>
</div>
 <form action="Empr.php" method="post">
   
<input type="hidden" name="titredelivre" value="<?php echo $ligne['Titre']; ?>">
<input type="hidden" name="numerodelivre" value="<?php echo $ligne['Numero']; ?>">

    <input class="button" id="submit" type="submit" value="Emprunter" name="submit">

</form>
</div>
<?php } ?>
</body>
</html>
