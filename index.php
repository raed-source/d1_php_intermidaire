<?php
//include('inc_connexion.php');
echo "bonjour";
echo 'git';
//roblem;


//si le nom de ville existe dans la base, on ajoute le user dans table user_searchs
//
if(isset($_POST['sybmit_form']))
{
    $ville_nom=$_POST['ville_nom'];
    $user=$_POST['user'];
    
    $resultat=$mysqli->query('SELECT ville_id, ville_nom FROM villes WHERE ville_nom= '.$ville_nom);
    while($row=$resultat->fetchArray())
    {
        $row[$ville_id['ville_id']]=$row['ville_nom'];
        $villes=$row['ville_nom'];
    }

    
}

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
    <form action="" method="POST">
        <p>Entrez votre nom <input type="text" name="user"> </p>
        <p>Entrez nom de ville <input type="text" name="ville_nom" > </p>
        <p><input type="submit" name="submit_form" value="valider"></p>
    </form>
    <?php
       
        //ne pas oblier la fermeture de connexion
    ?>
</body>
</html>