<?php

session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/style.css">
    <title>Choix de l'itinéraire manuel</title>

</head>

<body>
    <div class="containerTrajet">
        <?php
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';
        $chemin = '.';
        $input = 'trajet';
        $conn = OuvrirConnexionPDO($dbOracle, $db_usernameOracle, $db_passwordOracle);

        $cli_num = 0;
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
                where lig_num='" . $_GET['ligne'] . "'
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
                        if ($tab[$i]['ARRIVEE'] == $_GET['villefin']) {
                            $between = false;
                        }
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
                    echo "<h3>Vous devez modifier au moins une ville</h3>";
                } else {
                    echo "<h3>Correspondance ajoutée avec succès</h3>";
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


        echo "<a href=\"../../index.php\">Retour à l'accueil</a> <form method=\"get\"> <select multiple name=\"menuLigne\" id=\"menuLigne\" onchange=\"location = this.value;\">";
        echo "<option value='$chemin/$input.php'>Choisir une ligne</option>";

        $erreur = false;
        $sqlLig = "select lig_num, c.com_nom as depart, b.com_nom as arrivee from vik_ligne l
                    join  vik_commune c on c.com_code_insee=l.com_code_insee_debu 
                    join  vik_commune b on b.com_code_insee=l.com_code_insee_term
                    order by to_number(rtrim(trim(lig_num),'AB'))";

        $nbLignes = LireDonneesPDO1($conn, $sqlLig, $tab);
        if ($nbLignes == 0) {
            $erreur = true;
        }
        if (!$erreur) {
            for ($i = 0; $i < $nbLignes; $i++) {
                if (str_replace(" ", "", $tab[$i]['LIG_NUM']) == $_GET['ligne'] && !isset($_GET['ligne']))
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
                echo "<select multiple name=\"menuVilleDeb\" id=\"menuVilleDeb\" onchange=\"location = this.value;\">";
                afficherVilleDebut($_GET['ligne']);
                echo "</select> ";
            }

            include "choix_ville_fin.php";
            if (isset($_GET['villedeb']) && isset($_GET['ligne'])) {
                echo " <select multiple name=\"menuVilleTerm\" id=\"menuVilleTerm\" onchange=\"location = this.value;\">";
                afficherVilleTerm($_GET['ligne'], $_GET['villedeb']);
                echo "</select>";
            }

            include "choix_horaire.php";
            if (isset($_GET['villedeb']) && isset($_GET['ligne']) && isset($_GET['villefin'])) {
                echo " <select multiple name=\"menuHoraire\" id=\"menuHoraire\" onchange=\"location = this.value;\">";
                afficherHoraire($_GET['ligne'], $_GET['villedeb'], $_GET['villefin']);
                echo "</select>";
            }

            if (isset($_GET['villedeb']) && isset($_GET['ligne']) && isset($_GET['villefin']) && isset($_GET['heure'])) {
                echo "<br> <a href=\"./trajet.php?numRes=" . $_GET['numRes'] . "&ligne=" . $_GET['ligne'] . "&villedeb=" . $_GET['villedeb'] . "&villefin=" . $_GET['villefin'] . "&heure=" . $_GET['heure'] . "&submit=1\">Ajouter la correspondance/Valider</a>";
            }

            echo "</form>";
            // Visualisation du trajet
            $sql = "select lig_num, com_code_insee_depart, com_code_insee_arrivee, corr_distance, to_char(corr_heure,'hh24:mi') as corr_heure from vik_correspondance where res_num = '" . $_GET['numRes'] . "'";
            $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
            if ($nbLignes > 0) {
                echo "<h3>Trajets de la réservation</h3>";
                echo "<p>";
                $sql = "select com_nom from vik_commune where com_code_insee = '" . $tab[0]['COM_CODE_INSEE_DEPART'] . "'";
                $nbLignesB = LireDonneesPDO1($conn, $sql, $tab2);
                $sql = "select com_nom from vik_commune where com_code_insee = '" . $tab[0]['COM_CODE_INSEE_ARRIVEE'] . "'";
                $nbLignesB = LireDonneesPDO1($conn, $sql, $tab3);
                echo $tab2[0]['COM_NOM'] . " (" . $tab[0]['CORR_HEURE'] . ") ---------- " . $tab[0]['LIG_NUM'] . " - " . $tab[0]['CORR_DISTANCE'] . " km" . " ------->  " . $tab3[0]['COM_NOM'];
                for ($i = 1; $i < $nbLignes; $i++) {
                    $sql = "select com_nom from vik_commune where com_code_insee = '" . $tab[$i]['COM_CODE_INSEE_DEPART'] . "'";
                    $nbLignesB = LireDonneesPDO1($conn, $sql, $tab4);
                    $sql = "select com_nom from vik_commune where com_code_insee = '" . $tab[$i]['COM_CODE_INSEE_ARRIVEE'] . "'";
                    $nbLignesB = LireDonneesPDO1($conn, $sql, $tab5);
                    if ($tab3[0]['COM_NOM'] == $tab4[0]['COM_NOM']) {
                        echo " (" . $tab[$i]['CORR_HEURE'] . ")  -------- " . $tab[$i]['LIG_NUM'] . " - " . $tab[$i]['CORR_DISTANCE'] . " km ------->  " . $tab5[0]['COM_NOM'];
                    } else {
                        echo "<br>" . $tab4[0]['COM_NOM'] . " (" . $tab[$i]['CORR_HEURE'] . ") -------- " . $tab[$i]['LIG_NUM'] . " - " . $tab[$i]['CORR_DISTANCE'] . " km ------->  " . $tab5[0]['COM_NOM'];
                    }
                    $tab3[0]['COM_NOM'] = $tab5[0]['COM_NOM'];
                }

                // Distance totale et prix (mise à jour)
                $sql = "select sum(corr_distance) as distance_totale from vik_correspondance where res_num = '" . $_GET['numRes'] . "'";
                $nbLignesB = LireDonneesPDO1($conn, $sql, $tab2);
                $distance_totale = $tab2[0]['DISTANCE_TOTALE'];
                $distance_totale = str_replace(",", ".", $distance_totale);

                $sql = "select tar_valeur from vik_tarif where ceil($distance_totale) between tar_min_dist and tar_max_dist";
                $nbLignesB = LireDonneesPDO1($conn, $sql, $tab2);
                $prix_total = 0;
                if ($nbLignesB == 0) {
                    $prix_total = 90;
                } else {
                    $prix_total = $tab2[0]['TAR_VALEUR'];
                }

                echo "<br><br>Distance totale : " . $distance_totale . " km<br>Prix total : " . $prix_total . " €";
                $sql = "select tar_num_tranche from vik_tarif where ceil($distance_totale) between tar_min_dist and tar_max_dist";
                $nbLignesB = LireDonneesPDO1($conn, $sql, $tab2);
                $tranchePrix = 1;
                if ($nbLignesB == 0) {
                    $tranchePrix = 13;
                } else {
                    $tranchePrix = $tab2[0]['TAR_NUM_TRANCHE'];
                }
                $sql = "update vik_reservation set tar_num_tranche = " . $tranchePrix . ", res_nb_points = round(" . ($distance_totale / 10) . "), res_prix_tot = $prix_total where res_num = '" . $_GET['numRes'] . "'";
                echo $sql;
                $nbLignesB = majDonneesPDO($conn, $sql);
                
                // Bouton de paiement
                echo "<br><br><a href=\"./paiement.php?numRes=" . $_GET['numRes'] . "\">Payer la réservation 🤑</a>";
                echo "</p>";
            }


            $conn = null;
            ?>
        </form>
    </div>
</body>

</html>