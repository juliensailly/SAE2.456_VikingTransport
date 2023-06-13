<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../CSS/style.css">
</head>
<body>
    <a href="../../index.php">Retour à l'accueil</a>
    <?php
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

        if(isset($_GET['client_num'])){
            echo "<h1>Reservations de " . $_GET['client_prenom'] . " " . $_GET['client_nom'] . "</h1>";

            $sql = "select cli_nom, cli_prenom, res_num, tar_num_tranche, res_date, res_nb_points, res_prix_tot from vik_client
            join vik_reservation using(cli_num) 
            where cli_num=" .$_GET['client_num'] . "order by res_num desc";
            $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
            if($nbLignes == 0) {
                echo "<p>Ce client n'a pas de réservations</p>";
            } else {
                echo "<table> <tr> <th>Reservation num</th> <th>Tranche Tarif</th> <th>Date réservation</th> <th>Nombre de points</th> <th>Prix</th></tr>";
                for ($i = 0; $i < $nbLignes; $i++) {
                        echo "<tr> <td>" . $tab[$i]["RES_NUM"] . "</td> " . "<td>" . $tab[$i]["TAR_NUM_TRANCHE"] . "</td>" . "<td>" . $tab[$i]["RES_DATE"] . "</td>" . "<td>" . $tab[$i]["RES_NB_POINTS"] . "</td> " . "<td>" . $tab[$i]["RES_PRIX_TOT"] . "</td> </tr>";
                }
                echo "</table>";
            }
        } else {
            echo "<p>erreur</p>";
        }   
        $conn = null;
    ?>
</body>
</html>