<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href='../../index.php'>Retour à l'accueil</a>
    <?php
        $db_usernameOracle = "agile_1";
        $db_passwordOracle = "agile_1";
        $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
    
        include_once '../../pdo_agile.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        session_start();
        $email = $_SESSION['email'];


        $sql = "select cli_nom, cli_prenom, cli_courriel, cli_date_naiss, cli_nb_points_ec, cli_nb_points_tot from vik_client where cli_courriel = '$email'";
        $req = LireDonneesPDO2($conn, $sql, $tab);

        $nom = $tab[0]['CLI_NOM'];
        $prenom = $tab[0]['CLI_PRENOM'];
        $email = $tab[0]['CLI_COURRIEL'];
        $datenaiss = $tab[0]['CLI_DATE_NAISS'];
        $nbpts = $tab[0]['CLI_NB_POINTS_EC'];
        $nbptstot = $tab[0]['CLI_NB_POINTS_TOT'];

        echo "<h1>Profil de $nom $prenom</h1>";
        echo "<p> Email : $email</p>";
        echo "<p> Date de naissance : $datenaiss </p>";
        echo "<p> Nb points : $nbpts</p>";
        echo "<p> Nb points totaux : $nbptstot</p>";

        $sql = "select cli_num from vik_client where cli_courriel = '$email'";
        $req = LireDonneesPDO2($conn, $sql, $tab);
        $num = $tab[0]['CLI_NUM'];

        echo "<h2>Trajet</h2>";

        $sql = "select ";
        $req = LireDonneesPDO2($conn, $sql, $tab);
        for($i = 0; $i < count($tab); $i++){
            echo "<p> $tab[$i][''] </p>";
        }

        echo "<input type='button' value='Modifier' onclick='location.href=\"modifier_profil.php\"'>";
        $conn = null;
    ?>
</body>
</html>