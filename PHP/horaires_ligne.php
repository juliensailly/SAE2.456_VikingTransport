<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=${2:device-width}, initial-scale=${3:1.0}">
    <title>Horaires ligne</title>
</head>

<body>
    <form action="horaires_ligne.php" method="post">
        <select name="menuHoraire" id="menuHoraire">
            <option value="">-- Selectionner une ligne</option>
            <option value="1A">1A</option>
            <option value="1B">1B</option>
            <option value="2A">2A</option>
            <option value="2B">2B</option>
        </select>
        <input type="submit" value="submit">
    </form>
    <?php

    include "pdo_agile.php";
    if (isset($_POST['menuHoraire']) && $_POST['menuHoraire'] != "") {
        echo "<h1>Horaires de la ligne " . $_POST['menuHoraire'] . " :</h1>";

        $lig_num = $_POST['menuHoraire'];
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
            echo "<p>" . $ligne[$i]["HORAIRE"] . " " .$com[0]["COM_NOM"] . "</p>";
        }
       

        $sql = "SELECT com_nom from vik_commune where com_code_insee in (select com_code_insee from vik_noeud where lig_num = '$lig_num')";
        $cur = preparerRequetePDO($conn, $sql);
        $ligne = $cur->fetch(PDO::FETCH_ASSOC);
        $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
        LireDonneesPDOPreparee($cur, $ligne);
        echo "<table> <tr> <th>Communes desservies</th> <th>Horaires</th> </tr>";
        for($i = 0; $i < $nbLignes; $i++) {
            $sql = "SELECT to_char(noe_heure_passage, 'hh:mi') as horaire from vik_noeud where com_code_insee = (select com_code_insee from vik_commune where com_nom = '" . $ligne[$i]["COM_NOM"] . "') and lig_num = '$lig_num' order by to_char(noe_heure_passage, 'hh:mi')";
            $cur = preparerRequetePDO($conn, $sql);
            $com = $cur->fetch(PDO::FETCH_ASSOC);
            $nbLignesCom = LireDonneesPDO1($conn, $sql, $tab);
            LireDonneesPDOPreparee($cur, $com);
            echo "<tr> <td>" . $ligne[$i]["COM_NOM"] . "</td> <td>";
            for ($j = 0; $j < $nbLignesCom; $j++) {
                echo $com[$j]["HORAIRE"] . "<br> ";
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