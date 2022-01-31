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
    //------------------------recuperer les variables externes--------------------------

    if (isset($_POST['submit_form'])) {
        $web_ville_nom = $_POST['web_ville_nom']; // à remplacer par ville_id


        if (!empty($ville)) {
            $resultat = $mysqli->query('SELECT count(*) FROM villes WHERE ville_nom= "' . $web_ville_nom . '"');
            $row = $resultat->fetch_array();
            $count = $row[0];

            //----------------------verifier si la ville existe dans la base ici la table ville--------------------------------------
            if ($count <= 0) {
                $message = '<p> La ville saisie n\'existe pas saisissez une autre choix!</p<';
                //---------------------la ville est dans la base alors creer un cookie pour compter les nombre de visite-------------------------------

            } else {
                //-------la ville est dans la base----------------------------
                $resultat = $mysqli->query('SELECT ville_id , ville_nom FROM villes WHERE ville_nom= "' . $web_ville_nom . '"');
                $row = $resultat->fetch_array();
                $db_ville_id = $row['ville_id'];
                $db_ville_nom = $row['ville_nom'];
                // $db_ville_texte=$row['ville_texte'];
                $web_user_id = $_SESSION['user_id'];

                //------------ajouter les informations dans la base de donnee-----------------------
                $mysqli->query('INSERT INTO user_search (user_id,ville_id)VALUES("' . $web_user_id . '","' . $ville_id . '","' . $web_nb_visite . '")');
            }
        }
    }


    ?>
    <!-- ------------------------------------------------forme chercher ville---------------------------------------------- -->
    <form action="index.php" method="POST">
        <p>Entrez nom de ville <input type="text" name="web_ville_nom"> </p>
        <p><input type="submit" name="submit_form" value="valider"></p>
    </form>
    <!-- --------------------------------------------------liberation des variables--------------------------------------------------------- -->
    <?php if (isset($message)) : ?>
        <p><?php echo $message ?></p>
    <?php endif ?>
    <?php $resultat->free(); ?>
    <?php $mysqli->close(); ?>




</body>

</html>