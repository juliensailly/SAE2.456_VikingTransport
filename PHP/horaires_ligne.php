<?php
    include "pdo_agile.php";
    
    $conn = OuvrirConnexionPDO('info','agile1','agile1');
    $sql = "SELECT * FROM horaires_ligne";
    $cur = preparerRequetePDO($conn,$sql);
    $res = majDonneesPrepareesPDO($cur);
    $ligne = $cur->fetch(PDO::FETCH_ASSOC);
    while ($ligne != false) {
        echo $ligne['id_ligne']." ".$ligne['id_arret']." ".$ligne['heure']."<br>";
        $ligne = $cur->fetch(PDO::FETCH_ASSOC);
    }
    $cur->closeCursor();
    $conn = null;
    
?>