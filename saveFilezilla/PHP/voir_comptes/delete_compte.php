<?php

    function supprimerCompte($cli_num){
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        $supression = "DELETE FROM vik_client WHERE cli_num =" . $cli_num;
        $res = majDonneesPDO($conn, $supression);
        if($res)
            echo "<p>suppression réussi</p>";
        else
            echo "<p>error</p>";
        $conn = null;
    }

    function supprimerCompteReservation($cli_num){
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        $supression = "DELETE FROM vik_reservation WHERE cli_num = " . $cli_num;
        $res = majDonneesPDO($conn, $supression);
        $conn = null;
    }

    function supprimerCompteCorrespondance($cli_num){
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        $supression = "DELETE FROM vik_correspondance WHERE cli_num =" . $cli_num;
        $res = majDonneesPDO($conn, $supression);
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