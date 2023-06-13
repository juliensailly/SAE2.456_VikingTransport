<?php

function afficherVilleTerm($ligne, $ville_debu)
{
    include_once '../pdo_agile.php';
    include '../param_connexion_etu.php';

    $conn = OuvrirConnexionPDO($dbOracle, $db_usernameOracle, $db_passwordOracle);
    $erreur = false;

    $sql = "select depart, arrivee, noe_distance_prochain from 
    (
        select com1.com_nom as depart, com2.com_nom as arrivee, noe_distance_prochain, min(noe_heure_passage) as min_horaire
        from vik_noeud noe
        join vik_commune com1 on noe.com_code_insee=com1.com_code_insee
        join vik_commune com2 on noe.com_code_insee_suivant=com2.com_code_insee
        where lig_num='$ligne'
        group by (com1.com_nom, com2.com_nom, noe_distance_prochain)
    )
    order by min_horaire";
    $nbLigne = LireDonneesPDO1($conn, $sql, $tab);

    if ($nbLigne == 0)
        $erreur = true;
    if (!$erreur) {
        echo "<option value=''>Veuillez choisir la ville d'arrivée</option>";

        if ($_GET['villedeb'] == $tab[0]['DEPART']) {
            $bool = true;
        } else {
            $bool = false;
        }
        
        for ($i = 0; $i < $nbLigne; $i++) {
            if (isset($_GET['villefin']) && $bool == true) {
                if ($_GET['villefin'] == $tab[$i]['ARRIVEE']) {
                    echo "<option value='./trajet.php?ligne=" . $ligne . "&villedeb=" . $ville_debu . "&villefin=" . $tab[$i]['ARRIVEE'] . "' selected>" . $tab[$i]["ARRIVEE"] . "</option>";
                } else {
                    echo "<option value='./trajet.php?ligne=" . $ligne . "&villedeb=" . $ville_debu . "&villefin=" . $tab[$i]['ARRIVEE'] . "'>" . $tab[$i]["ARRIVEE"] . "</option>";
                }
            } else if ($bool == true) {
                echo "<option value='./trajet.php?ligne=" . $ligne . "&villedeb=" . $ville_debu . "&villefin=" . $tab[$i]['ARRIVEE'] . "'>" . $tab[$i]["ARRIVEE"] . "</option>";
            }

            if ($tab[$i]["ARRIVEE"] == $ville_debu) {
                echo $tab[$i]["ARRIVEE"] . " == " . $ville_debu;
                $bool = true;
            }
        }
    }
}

?>