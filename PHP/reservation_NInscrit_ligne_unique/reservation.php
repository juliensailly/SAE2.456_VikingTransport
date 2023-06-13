<?php
    
    include_once '../pdo_agile.php';
    include_once '../param_connexion_etu.php';

    $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

    $ligne = explode('=', $_POST['ligne'])[1];
    
?>