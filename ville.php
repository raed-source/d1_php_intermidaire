<?php
require('inc_connexion.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php
$id=$_GET['id'];
$resultat=$mysqli->query('SELECT * FROM villes WHERE ville_id='.$id);
$row=$resultat->fetch_array();
$ville_id= $row['ville_id'];
$ville_nom=$row['ville_nom'];
$ville_texte=$row['ville_texte'];
?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ville</title>
</head>
<body>
    <h2><a href="index.php">Accueil</a></h2>
    <h1><?php echo $id ?> - <?php echo $ville_nom?></h1>
    <textarea rows="10" cols="30"><?php echo $ville_texte;?></textarea>
    <?php require('inc_menu.php')?>
    <?php require('inc_footer.php')?>
</body>
</html>