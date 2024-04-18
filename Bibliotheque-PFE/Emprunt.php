
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>livres Emprunter</h2>
    <?php 


include("DataBase.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve data from the form

$sql =' SELECT livres.Titre Article,livres.Classe, livres.Categorie
FROM livres
INNER JOIN emprunt ON livres.N°= emprunt.N° 
and epmrunt.id_client = 1';
$result = mysqli_query($conn,$sql);

while ($row = mysqli_fetch_assoc($result)) {?>

  <tr>
      <td>  <?php echo $ligne['livres.Titre Article'] ?> </td>
      <td>  <?php echo $ligne['livres.Classe'] ?>        </td>
      <td>  <?php echo $ligne['livres.Categorie'] ?>     </td>

    <?php }} ?>
    
</body>
</html>

