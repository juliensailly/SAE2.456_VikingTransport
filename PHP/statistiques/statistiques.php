<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=${2:device-width}, initial-scale=${3:1.0}">
    <title>Statistiques du service</title>
</head>

<body>
    <h1>Statistiques du service</h1>
    <?php

    include "pdo_agile.php";
    $db_usernameOracle = "agile_1";
    $db_passwordOracle = "agile_1";
    $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
    $conn = ouvrirConnexionPDO($db, $db_username, $db_password);

    echo "<h2>Lignes les plus utilisées :</h2>";
    $sql = "SELECT lig_num, count(*) as nb FROM vik_correspondance GROUP BY lig_num ORDER BY nb DESC";
    
    ?>
</body>

</html>