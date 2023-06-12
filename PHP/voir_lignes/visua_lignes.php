<?php


function lireLignes($input,$chemin){
    include_once '../pdo_agile.php';
    include_once '../param_connexion_etu.php';
    $db_usernameOracle = "agile_1";
    $db_passwordOracle = "agile_1";
    $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
    $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

    $erreur = false;
    $sqlLig = "select lig_num,c.com_nom as depart ,b.com_nom as arrivee from vik_ligne l
                    join  vik_commune c on c.com_code_insee=l.com_code_insee_debu 
                    join  vik_commune b on b.com_code_insee=l.com_code_insee_term
                    where lig_num like '%A%' order by to_number(rtrim(trim(lig_num),'AB')) ";

    $nbLignes = LireDonneesPDO1($conn, $sqlLigParA, $tab);
    if ($nbLignes == 0) {
        $erreur = true;
    }
    if (!$erreur) {
        for ($i = 0; $i < $nbLignes; $i++) {
            echo "<option value='$chemin/$input.php?ligne=" . $tab[$i]['LIG_NUM'] . "'>" . $tab[$i]["LIG_NUM"] . " - " . $tab[$i]['DEPART'] . " → " . $tab[$i]['ARRIVEE'] . "</option>";
        }
    }
}


?>