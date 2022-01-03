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
        $user = $_POST['user'];
        $ville = $_POST['ville'];
        echo $user . ' ' . $ville;

        if ((empty($user)) or empty($ville)) {
            $message = 'veillez saisier une ville';
        } else {
            $resultat = $mysqli->query('SELECT count(*)  FROM villes WHERE ville_nom= "' . $ville . '"');
            $row = $resultat->fetch_array();
            if ($row[0] > 0) {

//-----------inserer la ville et user dans la table search et cree coockie pour enregistrer combien de fois la ville est saisie-----------------

                if ($mysqli->query('INSERT INTO user_search (user, ville) VALUES ("' . $user . '", "' . $ville . '")')) {
                    $message = 'ajouter dans la table de recherche';
                } else {
                    $message = 'erreur';
                }
            } else {
                $message = 'nouvelle ville';
            }
            //$mysqli->close();
        }
    }


    ?>

    <form action="index.php" method="POST">
        <p>Entrez votre nom <input type="text" name="user"> </p>
        <p>Entrez nom de ville <input type="text" name="ville"> </p>
        <p><input type="submit" name="submit_form" value="valider"></p>
    </form>

    <?php echo $message ?>
    <?php $mysqli->close(); ?>




</body>

</html>