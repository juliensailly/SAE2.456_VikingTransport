<?php
    function afficherVilleDebut($ligne) {
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';

        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        $erreur = false;

        $sql = "select distinct com_nom from vik_commune join vik_noeud using(com_code_insee) where lig_num = '" . $ligne ."'";
        $nbLigne =  LireDonneesPDO1($conn, $sql, $tab);
        
        if($nbLigne == 0)
            $erreur = true;
        if(!$erreur) {
            for($i = 0; $i < $nbLigne; $i++) {
                echo "<option value='./trajet.php?ligne=" . $ligne . "&villedeb=" . $tab[$i]["COM_NOM"] . "'>".$tab[$i]["COM_NOM"]."</option>";
            }
        }
    }
?>