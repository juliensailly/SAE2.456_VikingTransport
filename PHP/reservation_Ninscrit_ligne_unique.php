<?php
function TrajetinterLigne(){

    $db_usernameOracle = "agile_1";
	$db_passwordOracle = "agile_1"; 
	$dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
	$conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

    include_once '../pdo_agile.php';
    $erreur = false;
    //afficherTab($conn);


    $sqlRequeteArrivee = "select arrivee from 
    (
        select com2.com_nom as arrivee, min(noe_heure_passage) as min_horaire
        from vik_noeud noe
        join vik_commune com1 on noe.com_code_insee=com1.com_code_insee
        join vik_commune com2 on noe.com_code_insee_suivant=com2.com_code_insee
        where lig_num='2A'
        group by ( com2.com_nom)
    )
    order by min_horaire";

        //echo"$sqlRequeteArrivee ";

    $nbLignes = LireDonneesPDO1($conn,$sqlRequeteArrivee,$tabB);

        afficherTab($tabB);

    if($nbLignes == 0){
        $erreur=true;      
    }
    if(!$erreur){
        for($i=0; $i<$nbLignes; $i++){
            echo "<option value='option$i'>",$tabB[$i]["ARRIVEE"],"</option>";
        }
    }





}

//TrajetinterLigne();

?>