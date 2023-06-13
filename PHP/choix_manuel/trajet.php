<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Page d'accueil</title>

</head>

<body>
    <form method="get">
        <select name="menuLigne" id="menuLigne" onchange="location = this.value;">
            <?php
            include_once '../pdo_agile.php';
            include '../param_connexion_etu.php';
            $chemin = '.';
            $input = 'trajet';
            $db_usernameOracle = "agile_1";
            $db_passwordOracle = "agile_1";
            $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
            $conn = OuvrirConnexionPDO($dbOracle, $db_usernameOracle, $db_passwordOracle);
            
            echo "<option value='$chemin/$input.php'>Choisir une ligne</option>";

            $erreur = false;
            $sqlLig = "select lig_num, c.com_nom as depart, b.com_nom as arrivee from vik_ligne l
                    join  vik_commune c on c.com_code_insee=l.com_code_insee_debu 
                    join  vik_commune b on b.com_code_insee=l.com_code_insee_term
                    order by to_number(rtrim(trim(lig_num),'AB')) ";

            $nbLignes = LireDonneesPDO1($conn, $sqlLig, $tab);
            if ($nbLignes == 0) {
                $erreur = true;
            }
            if (!$erreur) {
                for ($i = 0; $i < $nbLignes; $i++) {
                    if (str_replace(" ", "", $tab[$i]['LIG_NUM']) == $_GET['ligne'])
                        echo "<option value='$chemin/$input.php?ligne=" . $tab[$i]['LIG_NUM'] . "' selected>" . $tab[$i]["LIG_NUM"] . " - " . $tab[$i]['DEPART'] . " → " . $tab[$i]['ARRIVEE'] . "</option>";
                    else
                        echo "<option value='$chemin/$input.php?ligne=" . $tab[$i]['LIG_NUM'] . "'>" . $tab[$i]["LIG_NUM"] . " - " . $tab[$i]['DEPART'] . " → " . $tab[$i]['ARRIVEE'] . "</option>";
                }
            }
            ?>
        </select>
    </form>
    <form>
            <?php
            include "choix_manuel.php";
            if (isset($_GET['ligne'])) {
                echo "<select name=\"menuVilleDeb\" id=\"menuVilleDeb\" onchange=\"location = this.value;\">";
                afficherVilleDebut($_GET['ligne']);
                echo "</select> ";
            }
            
            include "choix_ville_fin.php";
            if (isset($_GET['villedeb']) && isset($_GET['ligne'])) {
                echo " <select name=\"menuVilleTerm\" id=\"menuVilleTerm\" onchange=\"location = this.value;\">";
                afficherVilleTerm($_GET['ligne'], $_GET['villedeb']);
                echo "</select>";
            }

            include "choix_horaire.php";
            if (isset($_GET['villedeb']) && isset($_GET['ligne']) && isset($_GET['villefin'])) {
                echo " <select name=\"menuHoraire\" id=\"menuHoraire\" onchange=\"location = this.value;\">";
                afficherHoraire($_GET['ligne'], $_GET['villedeb'], $_GET['villefin']);
                echo "</select>";
            }

            if (isset($_GET['villedeb']) && isset($_GET['ligne']) && isset($_GET['villefin']) && isset($_GET['heure'])) {
                echo " <button type=\"submit\">Ajouter la correspondance</button>";
            }

            $conn = null;
            ?>
    </form>
</body>

</html>