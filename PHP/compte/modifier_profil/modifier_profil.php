<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification du profil</title>
</head>
    <body>
        
      <?php
        include_once '../../pdo_agile.php';
        $db_usernameOracle = "agile_1";
        $db_passwordOracle = "agile_1";
        $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        session_start();
        $email = $_SESSION['email'];

        $sql = "select cli_nom, cli_prenom, cli_courriel, cli_date_naiss, cli_password from vik_client where cli_courriel = '$email'";
        $req = LireDonneesPDO2($conn, $sql, $tab);

        $nom = $tab[0]['CLI_NOM'];
        $prenom = $tab[0]['CLI_PRENOM'];
        $email = $tab[0]['CLI_COURRIEL'];
        $datenaiss = $tab[0]['CLI_DATE_NAISS'];
        $password = $tab[0]['CLI_PASSWORD'];

        echo "<form>";
        echo "<h4>Nom :</h4>";
        echo "<input type='text' name='nom' value=$nom />";
        

        echo "<h4>Prénom :</h4>";
        echo "<input type='text' name='prenom' value=$prenom />";

        echo "<h4>Email :</h4>";
        echo "<input type='text' name='mail' value=$email />";

        echo "<h4>Date de naissance :</h4>";
        echo "<input type='text' name='datenaiss' value=$datenaiss />";

        echo "<h4>Mot de passe :</h4>";
        echo "<input type='text' name='pwd' value=$password />";

        

        echo "<br>";
        echo "<input type='button' value='Modifier'>";
        echo "<input type='button' value='Quitter' onclick='location.href=\"showProfil.php\"'>";
        $conn = null;
    ?>
</body>
</html>


    