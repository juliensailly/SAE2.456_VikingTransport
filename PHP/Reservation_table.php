<?php

function TableArriver($ligne){

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
        where lig_num='$ligne'
        group by ( com2.com_nom)
    )
    order by min_horaire";

        //echo"$sqlRequeteArrivee ";

    $nbLignes = LireDonneesPDO1($conn,$sqlRequeteArrivee,$tabC);

       // afficherTab($tabB);

    if($nbLignes == 0){
        $erreur=true;      
    }
    if(!$erreur){
        for($i=0; $i<$nbLignes; $i++){
           echo" <div><input type='radio' id='nom' name='arrive' value=",$tabC[$i]["ARRIVEE"],"><label for='nom'>",$tabC[$i]["ARRIVEE"],"</label> </div>";
        }
    }

}

function TableDepart($ligne){

    $db_usernameOracle = "agile_1";
	$db_passwordOracle = "agile_1"; 
	$dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
	$conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

    include_once '../pdo_agile.php';
    $erreur = false;
    //afficherTab($conn);


    $sqlRequeteArrivee = "select depart from 
    (
        select com1.com_nom as depart, min(noe_heure_passage) as min_horaire
        from vik_noeud noe
        join vik_commune com1 on noe.com_code_insee=com1.com_code_insee
        join vik_commune com2 on noe.com_code_insee_suivant=com2.com_code_insee
        where lig_num='$ligne'
        group by (com1.com_nom)
    )
    order by min_horaire";

        //echo"$sqlRequeteArrivee ";

    $nbLignes = LireDonneesPDO1($conn,$sqlRequeteArrivee,$tabV);

       // afficherTab($tabB);

    if($nbLignes == 0){
        $erreur=true;      
    }
    if(!$erreur){
        for($i=0; $i<$nbLignes; $i++){
           echo" <div><input type='radio' id='nom' name='depp' value=",$tabV[$i]["DEPART"],"><label for='nom'>",$tabV[$i]["DEPART"],"</label> </div>";
        }
    }
    $conn = null;
}


// function lireLignes(){
//     $cheminParent = dirname(__DIR__);
//     include_once $cheminParent . '/pdo_agile.php';
//     $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

//     $erreur = false;
//     $sqlLigParA = "select lig_num,c.com_nom as depart ,b.com_nom as arrivee from vik_ligne l
//                 join  vik_commune c on c.com_code_insee=l.com_code_insee_debu 
//                 join  vik_commune b on b.com_code_insee=l.com_code_insee_term
//                 where lig_num like '%A%'";
//     // echo sqlLigParA;
//     $sqlLigParB ="select lig_num,c.com_nom as depart ,b.com_nom as arrivee from vik_ligne l
//                 join  vik_commune c on c.com_code_insee=l.com_code_insee_debu 
//                 join  vik_commune b on b.com_code_insee=l.com_code_insee_term
//                 where lig_num like '%B%' ";
   
//     $nbLignes = LireDonneesPDO1($conn,$sqlLigParA,$tabA);
//     if($nbLignes == 0){
//         $erreur=true;
//     }
//     $nbLignes = LireDonneesPDO1($conn,$sqlLigParB,$tabB);
//     if($nbLignes == 0){
//         $erreur=true;      
//     }
//     if(!$erreur){
//         for($i=0; $i<$nbLignes; $i++){
//             echo "<option value='".$tabA[$i]["LIG_NUM"]."'>",$tabA[$i]["LIG_NUM"]," ", $tabA[$i]["DEPART"]," - ",$tabA[$i]["ARRIVEE"],"</option>";
//             $j = $i;
//             $y= $i+1;
//             echo "<option value='".$tabB[$i]["LIG_NUM"]."'>",$tabB[$i]["LIG_NUM"]," ", $tabB[$i]["DEPART"]," - ",$tabB[$i]["ARRIVEE"],"</option>";
//             $test[$i] = $tabA[$i]["LIG_NUM"];
//         }
//     }
// }
//TrajetinterLigne();

?>