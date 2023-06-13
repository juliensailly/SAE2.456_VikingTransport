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
    <form method="get">
        <select name="" id="" onchange="location=this.value;">
        <?php
            include_once '../pdo_agile.php';
            include '../param_connexion_etu.php';
            $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
            $erreur = false;
            $sql = "select cli_nom,cli_prenom,cli_num from vik_client";
            $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
            if ($nbLignes == 0) {
                $erreur = true;
            }
            if (!$erreur) {
                for ($i = 0; $i < $nbLignes; $i++) {
                    if (str_replace(" ", "", $tab[$i]['CLI_NUM']) == $_GET['client'])
                    echo "<option value='./voir_reservation.php?client=" .$tab[$i]['CLI_NUM']."'selected>". $tab[$i]['CLI_NUM'] . " : " . $tab[$i]["CLI_NOM"] . " " . $tab[$i]['CLI_PRENOM'] . "</option>";
                    else{
                    echo "<option value='./voir_reservation.php?client=" .$tab[$i]['CLI_NUM']."'>". $tab[$i]['CLI_NUM'] . " : " . $tab[$i]["CLI_NOM"] . " " . $tab[$i]['CLI_PRENOM'] . "</option>";
                    }
                }
            }

        ?>
        </select>
    </form>
    <?php
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        $erreur = false;
        if(isset($_GET['client'])){
            $sql = "select cli_nom, cli_prenom, res_num, tar_num_tranche, res_date, res_nb_points, res_prix_tot from vik_client
            join vik_reservation using(cli_num) 
            where cli_num=" .$_GET['client'];
            $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
            echo "<table> <tr> <th>Reservation num</th> <th>Tranche Tarif</th> <th>Date réservation</th> <th>Nombre de points</th> <th>Prix</th></tr>";
            for ($i = 0; $i < $nbLignes; $i++) {
                    echo "<tr> <td>" . $tab[$i]["RES_NUM"] . "</td> " . "<td>" . $tab[$i]["TAR_NUM_TRANCHE"] . "</td>" . "<td>" . $tab[$i]["RES_DATE"] . "</td>" . "<td>" . $tab[$i]["RES_NB_POINTS"] . "</td> " . "<td>" . $tab[$i]["RES_PRIX_TOT"] . "</td> </tr>";
            }
            echo "</table>";
        }
    ?>
</body>
</html>