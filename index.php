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
        $ville = $_POST['ville']; // à remplacer par ville_id


        if (!empty($ville)) {
            $resultat = $mysqli->query('SELECT count(*) as ville_fois, ville_id  FROM villes WHERE ville_nom= "' . $ville . '"');
            $row = $resultat->fetch_array();
            $count = $row['ville_fois'];
            $db_ville_id = $row['ville_id'];
            //----------------------verifier si la ville existe dans la base ici la table ville--------------------------------------
            if ($count > 0) {
                //---------------------la ville est dans la base alors creer un cookie pour compter les nombre de visite-------------------------------

                if (isset($_COOKIE['visite'])) {
                    $cookie_value = $_COOKIE['visite'];
                    //--------------------valeur de cookie---------------------------------------------------------------------
                    $cookie_value = unserialize($cookie_value);
                    $user_id = $cookie_value['user_id'];
                    $ville_id = $cookie_value[$db_ville_id];
                    $user_searche_data = serialize($cookie_value);
                    //-------------------insertion dans la table user_searche-------------------------------------------------
                    $mysqli->query('INSERT INTO user_search (user_id, ville_id)values("' . $user_id . '", "' . $ville_id . '"');
                } else {
                    
                }
            }
        }
    }

    ?>
    <!-- ------------------------------------------------forme chercher ville---------------------------------------------- -->
    <form action="index.php" method="POST">
        <p>Entrez votre nom <input type="text" name="user"> </p>
        <p>Entrez nom de ville <input type="text" name="ville"> </p>
        <p><input type="submit" name="submit_form" value="valider"></p>
    </form>
    <!-- --------------------------------------------------liberation des variables--------------------------------------------------------- -->
    <?php echo $message ?>
    <?php $mysqli->close(); ?>




</body>

</html>