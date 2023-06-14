<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Inactif</title>
    <link rel="stylesheet" href="../../CSS/style.css">
</head>
<body>
    <a href='../../index.php'>Retour à l'accueil</a>
    <h1>Liste des clients inactifs</h1>
    <?php
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        $sql = "select cli_num, cli_nom, cli_prenom, cli_ville, round(sysdate - cli_date_connec) as nb_jours_inactif from vik_client
        where sysdate - cli_date_connec > 730";
        $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
        if($nbLignes == 0) {
            echo "<p>Il n'y a pas de client inactif</p>";
        } else {
            echo "<table> <tr> <th>Numéro</th> <th>Nom</th> <th>Prenom</th> <th>Ville</th> <th>Nombre de jours inactifs</th></tr>";
            for ($i = 0; $i < $nbLignes; $i++) {
                echo "<tr> <td>" . $tab[$i]["CLI_NUM"] . "</td> <td>" . $tab[$i]["CLI_NOM"] . "</td> <td>" . $tab[$i]["CLI_PRENOM"] . "</td> <td>" . $tab[$i]["CLI_VILLE"] . "</td> <td>" . $tab[$i]["NB_JOURS_INACTIF"] . "</td> </tr>";
            }
            echo "</table>";
        }
    ?>
</body>
</html>