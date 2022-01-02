<?php
//--------------------------connexion aux base de donnees---------------------------------
$mysqli = new mysqli('localhost', 'root', '', 'projet-villes');



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ville_Users</title>
</head>

<body>
    <?php
    //------------------------si le nom de ville existe dans la base, on ajoute le user dans table user_searchs--------------------------

    // if (isset($_POST['submit_form'])) 
    // {
    $ville_nom = $_POST['ville_nom'];
    $user = $_POST['user'];

    $resultat = $mysqli->query('SELECT ville_id, ville_nom FROM villes  ville_nom');
    while ($row = $resultat->fetch_array()) {
        $villes[$row['ville_id']] = $row['ville_nom'];
    }

    //}
    ?>
    <form action="" method="POST">
        <p>Entrez votre nom <input type="text" name="user"> </p>
        <p>Entrez nom de ville <input type="text" name="ville_nom"> </p>
        <p><input type="submit" name="submit_form" value="valider"></p>
    </form>
    <ul>
        <?php foreach ($villes as $id => $ville) : ?>
            <li> <a href="index.php?id=<?php echo $id ?>"><?php echo $ville ?></a></li>
        <?php endforeach ?>
    </ul>

    <?php $resultat->free() ?>
    <?php $mysqli->close() ?>


</body>

</html>