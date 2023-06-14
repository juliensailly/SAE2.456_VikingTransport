<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=${2:device-width}, initial-scale=${3:1.0}">
    <title>Statistiques du service</title>
</head>

<body>
<nav>
        <ul>
            <li><a href="../../../index.php">ACCUEIL</a></li>
            <li><a href="../../horairesLignes/horaires_ligne.php">HORAIRES</a></li>
            <li><a href="../../choix_manuel/trajet.php" class="reserv">RESERVER</a></li>
          </ul>
    </nav>
    <a href='../../index.php'>Retour à l'accueil</a>
    <h1>Statistiques du service</h1>
    <?php

    include  "../pdo_agile.php";
    $db_usernameOracle = "agile_1";
    $db_passwordOracle = "agile_1";
    $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
    $conn = OuvrirConnexionPDO($dbOracle, $db_usernameOracle, $db_passwordOracle);

    echo "<h2>Lignes les plus utilisées :</h2>";
    $sql = "select * from top3
    where rownum<4";
    $cur = preparerRequetePDO($conn, $sql);
    $ligne = $cur->fetch(PDO::FETCH_ASSOC);
    $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
    LireDonneesPDOPreparee($cur, $ligne);
    foreach ($tab as $ligne) {
        echo "<p>La ligne n°" . $ligne['LIG_NUM'] . " a été utilisée " . $ligne['NBRESERV'] . " fois.</p>";
    }


    echo "<h2>Les meilleurs Clients (au rang Or):</h2>";
    $sql1 = "select * from vik_type_client
    join vik_client using(typ_num)
    where typ_num>=all ( select typ_num from vik_type_client)";
    $cur1 = preparerRequetePDO($conn, $sql1);
    $ligne = $cur1->fetch(PDO::FETCH_ASSOC);
    $nbLignes = LireDonneesPDO1($conn, $sql1, $tab1);
    LireDonneesPDOPreparee($cur1, $ligne1);
    foreach ($tab1 as $ligne) {
        echo "<p>Numéro : ".$ligne['CLI_NUM']. " / Nom : ".$ligne['CLI_NOM']." / Prénom : ".$ligne['CLI_PRENOM']. " / Nombre Point total : ". $ligne['CLI_NB_POINTS_TOT']. " / Grade : ".$ligne['TYP_NOM']." </p>";
    }

    

    $sql2 = "select round(avg(res_prix_tot),2) as PRIX_MOYEN from vik_reservation";
    $cur2 = preparerRequetePDO($conn, $sql2);
    $ligne2 = $cur2->fetch(PDO::FETCH_ASSOC);
    $nbLignes = LireDonneesPDO1($conn, $sql2, $tab2);
    LireDonneesPDOPreparee($cur2, $ligne2);
    foreach ($tab2 as $ligne2) {
        echo"<h2>Prix moyen de réservation :   ".$ligne2['PRIX_MOYEN']."€ </h2>";
    }
    $conn = null;
    



    ?>
</body>

</html>