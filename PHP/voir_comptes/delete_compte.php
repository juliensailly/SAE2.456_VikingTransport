<?php

    function supprimerCompte($cli_num){
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        $sql = "DELETE FROM vik_client WHERE cli_num =" . $cli_num . "and cli_num != 63";
        $res = majDonneesPDO($conn, $sql);
        if($res) {
            echo "<p>suppression réussi</p>";
        } else {
            echo "<p>error</p>";
        }
        $conn = null;
    }

    function modifierCompte($ancienNom, $AncienPrenom, $nouveauNom, $nouveauPrenom){
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        $modifier = "UPDATE vik_client SET cli_nom = $nouveauNom, cli_prenom = $nouveauPrenom  WHERE cli_nom = $nouveauNom and cli_prenom = $nouveauPrenom)";
        majDonneesPDO($connexion, $supression);
        $conn = null;
    }
?>