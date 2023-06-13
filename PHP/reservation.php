<?php
    
    include_once '../pdo_agile.php';
    include_once '../param_connexion_etu.php';

    $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

    $ligne = explode('=', $_POST['ligne'])[1];
    $sql = "select depart from 
    (
        select com1.com_nom as depart, min(noe_heure_passage) as min_horaire
        from vik_noeud noe
        join vik_commune com1 on noe.com_code_insee=com1.com_code_insee
        join vik_commune com2 on noe.com_code_insee_suivant=com2.com_code_insee
        where $ligne
        group by (com1.com_nom)
    )
    order by min_horaire";

    $nbLigne =  LireDonneesPDO1($conn, $sql, $tab);
    
    if($nbLigne != 0){
        for($i=0; $i<$nbLignes; $i++){
            echo" <div><input type='radio' id='nom' name='depp'><label for='nom'>",$tab[$i]["DEPART"],"</label> </div>";
        }
    }
?>