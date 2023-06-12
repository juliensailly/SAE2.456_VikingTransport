

<?php

    function lireLignes(){
        $cheminParent = dirname(__DIR__);
        include_once $cheminParent . '/pdo_agile.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

        $erreur = false;
        $sqlLigParA = "select lig_num,c.com_nom as depart ,b.com_nom as arrivee from vik_ligne l
                    join  vik_commune c on c.com_code_insee=l.com_code_insee_debu 
                    join  vik_commune b on b.com_code_insee=l.com_code_insee_term
                    where lig_num like '%A%'";
        // echo sqlLigParA;
        $sqlLigParB ="select lig_num,c.com_nom as depart ,b.com_nom as arrivee from vik_ligne l
                    join  vik_commune c on c.com_code_insee=l.com_code_insee_debu 
                    join  vik_commune b on b.com_code_insee=l.com_code_insee_term
                    where lig_num like '%B%' ";
       
        $nbLignes = LireDonneesPDO1($conn,$sqlLigParA,$tabA);
        if($nbLignes == 0){
            $erreur=true;
        }
        $nbLignes = LireDonneesPDO1($conn,$sqlLigParB,$tabB);
        if($nbLignes == 0){
            $erreur=true;      
        }
        if(!$erreur){
            for($i=0; $i<$nbLignes; $i++) {
                echo "<option value='PHP/horairesLignes/horaires_ligne.php?ligne=".$tabA[$i]['LIG_NUM']."'>".$tabA[$i]["LIG_NUM"]." - ".$tabA[$i]['DEPART']." → ".$tabA[$i]['ARRIVEE']."</option>";
                $y= $i+1;
                echo "<option value='PHP/horairesLignes/horaires_ligne.php?ligne=".$tabB[$i]['LIG_NUM']."'>".$tabB[$i]["LIG_NUM"]." - ".$tabB[$i]['DEPART']." → ".$tabB[$i]['ARRIVEE']."</option>";
            }
        }
    }

    
?>
