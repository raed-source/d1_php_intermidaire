<?php
require('inc_connexion.php');
require('inc_identification_user.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php

    if (isset($_POST['submit_form'])) {
        if (!empty($_POST['web_ville_nom'])) {
            $web_ville_nom = $_POST['web_ville_nom'];
            //requete pour chercher la ville dans la base de donnee
            $resultat = $mysqli->query('SELECT count(*) FROM villes WHERE ville_nom= "' . $web_ville_nom . '"');
            $row = $resultat->fetch_array();
            $count = $row[0];
            if ($count > 0) {
                //la ville est dans la base

                $resultat = $mysqli->query('SELECT ville_id, ville_nom FROM villes WHERE ville_nom= "' . $web_ville_nom . '"');
                $row = $resultat->fetch_array();
                $db_ville_id = $row['ville_id'];
                $db_ville_nom = $row['ville_nom'];
                $message = '<p>la ville numero <a href="searche.php">' . $db_ville_id . '</a> est sauvguardée dans notre base</p>';
                //recuperer le user_id

                if (isset($_SESSION['user_mail'])) {
                    $user_mail = $_SESSION['user_mail'];
                    echo $user_mail . '<br>';
                    $resultat = $mysqli->query('SELECT user_id from users WHERE user_mail="' . $user_mail . '"');
                    $row = $resultat->fetch_array();
                    $db_user_id = $row['user_id'];
                    echo $db_user_id . '<br>';
                    echo $db_ville_id . 'à inserer dans la base';
                    if ($mysqli->query('INSERT INTO user_search (user_id, ville_id)VALUES (' . $db_user_id . ', ' . $db_ville_id . ')')) {
                        $message = 'Le user_id et la <a href="ville.php?id=' . $db_ville_id . '">' . $web_ville_nom . '</a> ont été ajoutés à la base de données';
                    } else {
                        $message = '<p>Erreur d\'insertion des informations</p>';
                    }
                } else {
                    $message = '<p>vous n\'etes pas connecté</p>';
                }
                //insertion de ville_id et user_id dans la table user_searche

            } else {
                $message = '<p>la ville n\'est pas disponible! </p>';
            }
        } else {
            $message = '<p>veuillez saisir une ville</p>';
        }
    }

    ?>
</head>

<body>


    <h4><a href="index.php">retour à l'accuil</a></h4>
    <h3>page de recherche</h3>
    <form action="" method="POST">
        <p>Entrez une ville <input type="text" name="web_ville_nom"> </p>
        <p><input type="submit" name="submit_form" value="valider"></p>

    </form>
    <p><?php echo $message; ?></p>

    <h2>Les recherches effectuées par: <?php echo $user_mail ?></h2>
    <?php
    $resultat = $mysqli->query('SELECT * FROM user_search');
    while ($row = $resultat->fetch_array()) {
        $searche_id = $row['search_id'];
        $searche_user_id = $row['user_id'];
        $searche_ville_id = $row['ville_id'];
        $searches[] = $row['ville_id'];
    }
    ?>
    <ul>
        <?php foreach ($searches as $id) : ?>
            <li>
                <a href="ville.php?id=<?php echo $id ?>">Allez à la ville numero: <?php echo $id ?> </a>


            </li>
        <?php endforeach ?>
    </ul>

</body>

</html>