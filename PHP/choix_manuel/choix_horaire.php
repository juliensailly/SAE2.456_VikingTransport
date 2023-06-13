<?php

function afficherHoraire($ligne, $villedeb, $villefin)
{
    include_once '../pdo_agile.php';
    include '../param_connexion_etu.php';

    $conn = OuvrirConnexionPDO($dbOracle, $db_usernameOracle, $db_passwordOracle);
    $erreur = false;


    $sql = "SELECT to_char(noe_heure_passage, 'hh24:mi') as horaire from vik_noeud where com_code_insee = (
        select com_code_insee from vik_commune where com_nom = '" . $villedeb . "'
        ) and lig_num = '$ligne' order by horaire";
    $nbLigne = LireDonneesPDO1($conn, $sql, $tab);

    if ($nbLigne == 0)
        $erreur = true;
    if (!$erreur) {
        echo "<option value='./trajet.php?ligne=" . $ligne . "&villedeb=" . $_GET['villedeb'] . "&villefin=" . $_GET['villefin'] . "'>Veuillez choisir l'horaire au départ de " . $villedeb . "</option>";
        for ($i = 0; $i < $nbLigne; $i++) {
            if (isset($_GET['heure'])) {
                if ($_GET['heure'] == $tab[$i]['HORAIRE']) {
                    echo "<option value='./trajet.php?ligne=" . $ligne . "&villedeb=" . $_GET['villedeb'] . "&villefin=" . $_GET['villefin'] . "&heure=" . $tab[$i]["HORAIRE"] . "' selected>" . $tab[$i]["HORAIRE"] . "</option>";
                } else {
                    echo "<option value='./trajet.php?ligne=" . $ligne . "&villedeb=" . $_GET['villedeb'] . "&villefin=" . $_GET['villefin'] . "&heure=" . $tab[$i]["HORAIRE"] . "'>" . $tab[$i]["HORAIRE"] . "</option>";
                }
            } else {
                echo "<option value='./trajet.php?ligne=" . $ligne . "&villedeb=" . $_GET['villedeb'] . "&villefin=" . $_GET['villefin'] . "&heure=" . $tab[$i]["HORAIRE"] . "'>" . $tab[$i]["HORAIRE"] . "</option>";
            }
        }
    }
}




?>