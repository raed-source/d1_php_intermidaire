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
            $resultat = $mysqli->query('SELECT count(*) as fois, ville_id, ville_nom  FROM villes WHERE ville_nom= "' . $ville . '"');
            $row = $resultat->fetch_array();
            $count = $row['fois'];
            $db_ville_id = $row['ville_id'];
            $db_ville_nom=$row['ville_nom'];
            //----------------------verifier si la ville existe dans la base ici la table ville--------------------------------------
            if ($count > 0) {
                //---------------------la ville est dans la base alors creer un cookie pour compter les nombre de visite-------------------------------
                //----------------ce cookie contient dex valeur le nom de la ville , et id de user ou user_id dans la base--------------
                if (isset($_COOKIE['visite'])) {
                    $cookie_value = $_COOKIE['visite'];
                    //--------------------valeur de cookie---------------------------------------------------------------------
                    $cookie_value = unserialize($cookie_value);
                    $web_user_id = $cookie_value['web_user_id'];
                    $web_ville_id = $cookie_value['web_ville_id'];
                    $web_nb_visite=$cookie_value['web_nb_visite'];
                    $web_nb_visite++;
                    $searche_data = serialize($cookie_value);
                    //-------------------insertion dans la table user_searche-------------------------------------------------
                    $mysqli->query('UPDATE user_search SET  nb_visite="'.$web_nb_visite.'" WHERE user_id="'.$web_user_id.'"');
                    $message='bonjout c\'est votre '.$web_nb_visite; 
                } else {
                    //-------le cookie n'existe pas creer un cookie visite----------------------------
                    $web_user_id= uniqid();
                    $web_ville_id=$db_ville_id;
                    $web_nb_visite=1;
                    $searche_data['web_user_id']=$web_user_id;
                    $searche_data['web_ville_id']=$web_ville_id;
                    $searche_data['web_nb_visite']=$web_nb_visite;
                    $searche_data=serialize($searche_data);
                    //------------ajouter les informations dans la base de donnee-----------------------
                    $mysqli->query('INSERT INTO user_search (user_id,ville_id,nb_visite)VALUES("'.$web_user_id.'","'.$web_ville_id.'","'.$web_nb_visite.'")');

                }
                setcookie('visite',$searche_data,time()+ 259200);
                $message='bonjour c\'votre visite le '.$web_nb_visite;

            }
        }
    }

    ?>
    <!-- ------------------------------------------------forme chercher ville---------------------------------------------- -->
    <form action="index.php" method="POST">
        <p>Entrez nom de ville <input type="text" name="ville"> </p>
        <p><input type="submit" name="submit_form" value="valider"></p>
    </form>
    <!-- --------------------------------------------------liberation des variables--------------------------------------------------------- -->
    <?php if(isset($message)): ?>
    <p><?php echo $message?></p>
    <?php endif ?>
    <?php $resultat->free();?>
    <?php $mysqli->close(); ?>




</body>

</html>