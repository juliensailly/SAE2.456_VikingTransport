<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=${2:device-width}, initial-scale=${3:1.0}">
    <title>Horaires ligne</title>
</head>

<body>
    <?php

    include "pdo_agile.php";
    if (isset($_GET['ligne']) && $_GET['ligne'] != "") {
        echo "<a href='../../index.php'>Retour à l'accueil</a>";
        $sql = "select lig_num from vik_ligne where lig_num = '" . $_GET['ligne'] . "'";
        if (LireDonneesPDO1($conn, $sql, $tab) == 0) {
            echo "<h1>La ligne " . $_GET['ligne'] . " n'existe pas</h1>";
            exit();
        }

        echo "<h1>Horaires de la ligne " . $_GET['ligne'] . " :</h1>";

        $lig_num = $_GET['ligne'];
        $sql = "select to_char(noe_heure_passage, 'hh:mi') as horaire from vik_noeud where lig_num = '$lig_num' order by to_char(noe_heure_passage, 'hh:mi')";
        $cur = preparerRequetePDO($conn, $sql);
        $ligne = $cur->fetch(PDO::FETCH_ASSOC);
        $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
        LireDonneesPDOPreparee($cur, $ligne);
        for($i = 0; $i < $nbLignes; $i++) {
            $sql = "SELECT com_nom FROM vik_commune WHERE com_code_insee = (SELECT com_code_insee FROM vik_noeud WHERE to_char(noe_heure_passage, 'hh:mi') = '" . $ligne[$i]["HORAIRE"] . "' and lig_num = '$lig_num')";
            $cur = preparerRequetePDO($conn, $sql);
            $com = $cur->fetch(PDO::FETCH_ASSOC);
            LireDonneesPDOPreparee($cur, $com);
            if (isset($com[0]["COM_NOM"])) {
                echo "<p>" . $ligne[$i]["HORAIRE"] . " " .$com[0]["COM_NOM"] . "</p>";
            }
        }
       

        $sql = "SELECT com_nom from vik_commune where com_code_insee in (select com_code_insee from vik_noeud where lig_num = '$lig_num')";
        $cur = preparerRequetePDO($conn, $sql);
        $ligne = $cur->fetch(PDO::FETCH_ASSOC);
        $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
        LireDonneesPDOPreparee($cur, $ligne);
        echo "<table> <tr> <th>Communes desservies</th> <th colspan=100%>Horaires</th> </tr>";
        for($i = 0; $i < $nbLignes; $i++) {
            $sql = "SELECT to_char(noe_heure_passage, 'hh:mi') as horaire from vik_noeud where com_code_insee = (select com_code_insee from vik_commune where com_nom = '" . $ligne[$i]["COM_NOM"] . "') and lig_num = '$lig_num' order by to_char(noe_heure_passage, 'hh:mi')";
            $cur = preparerRequetePDO($conn, $sql);
            $com = $cur->fetch(PDO::FETCH_ASSOC);
            $nbLignesCom = LireDonneesPDO1($conn, $sql, $tab);
            LireDonneesPDOPreparee($cur, $com);
            echo "<tr> <td>" . $ligne[$i]["COM_NOM"] . "</td> <td>";
            for ($j = 0; $j < $nbLignesCom; $j++) {
                echo "<td>".$com[$j]["HORAIRE"] . "</td> ";
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