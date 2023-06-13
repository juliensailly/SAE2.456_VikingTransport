<?php

session_start();
?>

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
    <?php
    include_once '../pdo_agile.php';
    include '../param_connexion_etu.php';
    $chemin = '.';
    $input = 'trajet';
    $db_usernameOracle = "agile_1";
    $db_passwordOracle = "agile_1";
    $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
    $conn = OuvrirConnexionPDO($dbOracle, $db_usernameOracle, $db_passwordOracle);

    if (isset($_GET['numRes']) && !isset($_GET['ligne'])) {
        if (isset($_SESSION['email'])) {
            $sql = "select cli_num from vik_client where cli_courriel = '" . $_SESSION['email'] . "'";
            $nbLignes = LireDonneesPDO1($conn, $sql, $tab);

            if ($nbLignes == 0) {
                $cli_num = 0;
            } else {
                $cli_num = $tab[0]['CLI_NUM'];
            }
        } else {
            $cli_num = 0;
        }

        $sql = "insert into vik_reservation (cli_num, res_num, tar_num_tranche, res_date, res_nb_points, res_prix_tot) values ('" . $cli_num . "', (select max(res_num)+1 from vik_reservation), 1, sysdate, 0, 0)";
        // Update tar_num_tranche, res_nb_points et res_prix_tot
        $nbLignes = majDonneesPDO($conn, $sql);
    }

    if (isset($_GET['submit'])) {
        if ($_GET['submit'] == '1') {
            $sql = "select com_code_insee from vik_commune where com_nom = '" . $_GET['villedeb'] . "'";
            $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
            $code_insee_deb = $tab[0]['COM_CODE_INSEE'];
            $sql = "select com_code_insee from vik_commune where com_nom = '" . $_GET['villefin'] . "'";
            $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
            $code_insee_fin = $tab[0]['COM_CODE_INSEE'];

            // Récupération de la distance totale de la correspondance
            $sql = "select depart, arrivee, noe_distance_prochain from 
            (
                select com1.com_nom as depart, com2.com_nom as arrivee, noe_distance_prochain, min(noe_heure_passage) as min_horaire
                from vik_noeud noe
                join vik_commune com1 on noe.com_code_insee=com1.com_code_insee
                join vik_commune com2 on noe.com_code_insee_suivant=com2.com_code_insee
                where lig_num='1A'
                group by (com1.com_nom, com2.com_nom, noe_distance_prochain)
            )
            order by min_horaire";
            $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
            $between = false;
            $sum = 0;
            for ($i = 0; $i < $nbLignes; $i++) {
                if ($tab[$i]['DEPART'] == $_GET['villedeb'] || $between == true) {
                    $between = true;
                    $sum += floatval(str_replace(',', '.', $tab[$i]['NOE_DISTANCE_PROCHAIN']));
                }
            }

            if (isset($_SESSION['email'])) {
                $sql = "select cli_num from vik_client where cli_courriel = '" . $_SESSION['email'] . "'";
                $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
                if ($nbLignes == 0) {
                    $cli_num = 0;
                } else {
                    $cli_num = $tab[0]['CLI_NUM'];
                }
            } else {
                $cli_num = 0;
            }

            $sql = "insert into vik_correspondance values ('" . $_GET['ligne'] . "','" . $cli_num . "','" . $_GET['numRes'] . "','$code_insee_deb','$code_insee_fin','" . number_format($sum, 1, ",", " ") . "',to_date('" . $_GET['heure'] . ":00','hh24:mi:ss'))";
            $nbLignes = majDonneesPDO($conn, $sql);
            if ($nbLignes == 0) {
                echo "<h1>Erreur lors de l'insertion de la correspondance</h1>";
            } else {
                echo "<h1>Correspondance ajoutée avec succès</h1>";
            }
        }
    }

    if (!isset($_GET['ligne']) && !isset($_GET['numRes'])) {
        $sql = "select max(res_num)+1 as max from vik_reservation";
        $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
        $res_num = $tab[0]['MAX'];
        echo "<a href=\"trajet.php?numRes=" . $res_num . "\">Créer une réservation</a>";
        $conn = null;
        exit();
    }


    echo "<a href=\"../../index.php\">Retour à l'accueil</a> <form method=\"get\"> <select name=\"menuLigne\" id=\"menuLigne\" onchange=\"location = this.value;\">";
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
                echo "<option value='$chemin/$input.php?numRes=" . $_GET['numRes'] . "&ligne=" . $tab[$i]['LIG_NUM'] . "' selected>" . $tab[$i]["LIG_NUM"] . " - " . $tab[$i]['DEPART'] . " → " . $tab[$i]['ARRIVEE'] . "</option>";
            else
                echo "<option value='$chemin/$input.php?numRes=" . $_GET['numRes'] . "&ligne=" . $tab[$i]['LIG_NUM'] . "'>" . $tab[$i]["LIG_NUM"] . " - " . $tab[$i]['DEPART'] . " → " . $tab[$i]['ARRIVEE'] . "</option>";
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
            echo " <a href=\"./trajet.php?numRes=" . $_GET['numRes'] . "&ligne=" . $_GET['ligne'] . "&villedeb=" . $_GET['villedeb'] . "&villefin=" . $_GET['villefin'] . "&heure=" . $_GET['heure'] . "&submit=1\">Ajouter la correspondance</button>";
        }

        $sql = "s";

        
        
        $conn = null;
        ?>
    </form>
</body>

</html>