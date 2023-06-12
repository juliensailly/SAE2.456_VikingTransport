<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=${2:device-width}, initial-scale=${3:1.0}">
    <title>Horaires ligne</title>
</head>

<body>
    <form action="horaires_ligne" method="post">
        <select name="menuHoraire" id="menuHoraire">
            <option value="">-- Selectionner une ligne</option>
            <option value="1A">1A</option>
            <option value="1B">1B</option>
            <option value="21">2B</option>
            <option value="2A">2A</option>
        </select>
    </form>
    <?php

    include "pdo_agile.php";

    if (isset($_POST['menuHoraire'])) {
        $lig_num = $_POST['menuHoraire'];

        $sql = "select to_char(noe_heure_passage, 'hh:mi') from vik_noeud where $lig_num = '1A' order by to_char(noe_heure_passage, 'hh:mi:ss')";
        $cur = preparerRequetePDO($conn, $sql);
        $res = majDonneesPrepareesPDO($cur);
        $ligne = $cur->fetch(PDO::FETCH_ASSOC);
        while ($ligne != false) {
            echo $ligne['id_ligne'] . " " . $ligne['id_arret'] . " " . $ligne['heure'] . "<br>";
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