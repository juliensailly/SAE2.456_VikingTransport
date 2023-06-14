<?php
    include_once '../pdo_agile.php';
    include '../param_connexion_etu.php';
    function cheminMin($villeDepart,$villeArrivee){
        $sql = "select distinct lig_num, com.com_nom, com_suivant.com_nom as com_nom_suivant, noe_distance_prochain from vik_commune com
        join vik_noeud noe using(com_code_insee)
        join vik_commune com_suivant on com_suivant.com_code_insee = noe.com_code_insee_suivant
        where com.com_nom = 'Caen' order by noe_distance_prochain" ;

    }


?>