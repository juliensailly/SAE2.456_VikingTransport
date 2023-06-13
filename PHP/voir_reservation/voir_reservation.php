<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    

   


</body>
</html>