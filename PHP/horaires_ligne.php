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
        $lig_num = $_POST['menuHoraire'];
        $sql = "select to_char(noe_heure_passage, 'hh:mi') as horaire from vik_noeud where lig_num = '$lig_num' order by to_char(noe_heure_passage, 'hh:mi')";
        $cur = preparerRequetePDO($conn, $sql);
        $ligne = $cur->fetch(PDO::FETCH_ASSOC);
        $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
        LireDonneesPDOPreparee()
        echo "aaaa";
        echo $ligne[0]["HORAIRE"];
        while($ligne != false){
            echo "<p>" . $ligne[0]["HORAIRE"] . "</p>";
            $ligne = $cur->fetch(PDO::FETCH_ASSOC);
        }
        $cur->closeCursor();
        $conn = null;
    } else {
        echo "Erreur, pas de ligne sélectionnée";
    }
    ?>
</body>

</html>