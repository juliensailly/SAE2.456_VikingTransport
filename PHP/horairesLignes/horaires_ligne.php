<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=${2:device-width}, initial-scale=${3:1.0}">
    <?php
    if (isset($_GET['ligne']) && $_GET['ligne'] != "") {
        echo "<title>Horaires de la ligne " . $_GET['ligne'] . "</title>";
    } else {
        echo "<title>Horaires - Ligne incorrecte</title>";
    }
    ?>
</head>

<body>
    <?php

    include_once "../pdo_agile.php";
    $db_usernameOracle = "agile_1";
    $db_passwordOracle = "agile_1";
    $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";

    $conn = ouvrirConnexionPDO($dbOracle, $db_usernameOracle, $db_passwordOracle);
    setlocale(LC_CTYPE, 'fr_FR');

    if (isset($_GET['ligne']) && $_GET['ligne'] != "") {
        echo "<a href='../../index.php'>Retour à l'accueil</a>";
        $sql = "select lig_num from vik_ligne where lig_num = '" . $_GET['ligne'] . "'";
        if (LireDonneesPDO1($conn, $sql, $tab) == 0) {
            echo "<h1>La ligne " . $_GET['ligne'] . " n'existe pas</h1>";
            exit();
        }

        echo "<h1>Horaires de la ligne " . $_GET['ligne'] . " :</h1>";

        $lig_num = $_GET['ligne'];

        //$sql = "SELECT com_code_insee from vik_commune where com_code_insee in (select com_code_insee from vik_noeud where lig_num = '$lig_num') or com_code_insee in (select com_code_insee_suivant from vik_noeud where lig_num = '$lig_num')";
        $sql = "select depart, arrivee, noe_distance_prochain from 
        (
            select com1.com_nom as depart, com2.com_nom as arrivee, noe_distance_prochain, min(noe_heure_passage) as min_horaire
            from sae.vik_noeud noe
            join sae.vik_commune com1 on noe.com_code_insee=com1.com_code_insee
            join sae.vik_commune com2 on noe.com_code_insee_suivant=com2.com_code_insee
            where lig_num='1A'
            group by (com1.com_nom, com2.com_nom, noe_distance_prochain)
        )
        order by min_horaire";
        $cur = preparerRequetePDO($conn, $sql);
        $ligne = $cur->fetch(PDO::FETCH_ASSOC);
        $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
        LireDonneesPDOPreparee($cur, $ligne);
        echo "<table> <tr> <th>Communes desservies</th> <th colspan=100%>Horaires</th> </tr>";
        for ($i = 0; $i < $nbLignes; $i++) {
            $sql = "SELECT to_char(noe_heure_passage, 'hh24:mi') as horaire from vik_noeud where com_code_insee = (select com_code_insee from vik_commune where com_code_insee = '" . $ligne[$i]["COM_CODE_INSEE"] . "') and lig_num = '$lig_num' order by horaire";
            $cur = preparerRequetePDO($conn, $sql);
            $com = $cur->fetch(PDO::FETCH_ASSOC);
            $nbLignesCom = LireDonneesPDO1($conn, $sql, $tab);
            LireDonneesPDOPreparee($cur, $com);

            $sql2 = "SELECT com_nom from vik_commune where com_code_insee = '" . $ligne[$i]["DEPART"] . "'";
            $cur2 = preparerRequetePDO($conn, $sql2);
            $com2 = $cur2->fetch(PDO::FETCH_ASSOC);
            // $nbLignesCom2 = LireDonneesPDO1($conn, $sql2, $tab2);
            LireDonneesPDOPreparee($cur2, $com2);
            echo "<tr> <td>" . $com2[0]["COM_NOM"] . "</td> <td>";
            for ($j = 0; $j < $nbLignesCom; $j++) {
                if (isset($com[$j]["HORAIRE"]) && $com[$j]["HORAIRE"] != "") {
                    echo "<td>" . $com[$j]["HORAIRE"] . "</td> ";
                } else {
                    echo "<td> - </td>";
                }
            }
            echo "<td/> </tr>";
        }
        echo "</table>";
        $cur->closeCursor();
    } else {
        echo "Veuillez sélectionner une ligne";
    }
    ?>
</body>

</html>