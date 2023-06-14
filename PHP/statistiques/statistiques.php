<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=${2:device-width}, initial-scale=${3:1.0}">
    <title>Statistiques du service</title>
</head>

<body>
    <a href='../../index.php'>Retour à l'accueil</a>
    <h1>Statistiques du service</h1>
    <?php

    include_once "pdo_agile.php";

    $db_usernameOracle = "agile_1";
    $db_passwordOracle = "agile_1";
    $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
    $conn = ouvrirConnexionPDO($db, $db_username, $db_password);

    echo "<h2>Lignes les plus utilisées :</h2>";
    $sql = "SELECT lig_num, count(*) as nb FROM vik_correspondance GROUP BY lig_num ORDER BY nb DESC";
    $cur = preparerRequetePDO($conn, $sql);
    $ligne = $cur->fetch(PDO::FETCH_ASSOC);
    $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
    LireDonneesPDOPreparee($cur, $ligne);
    foreach ($tab as $ligne) {
        echo "<p>La ligne n°" . $ligne['lig_num'] . " a été utilisée " . $ligne['nb'] . " fois.</p>";
    }
    ?>
</body>

</html>