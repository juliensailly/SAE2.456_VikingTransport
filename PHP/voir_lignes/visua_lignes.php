

<?php

    function lireLignes($input,$chemin){
        include_once '../pdo_agile.php';
        include_once '../param_connexion_etu.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

        $erreur = false;
        $sqlLigParA = "select lig_num,c.com_nom as depart ,b.com_nom as arrivee from vik_ligne l
                    join  vik_commune c on c.com_code_insee=l.com_code_insee_debu 
                    join  vik_commune b on b.com_code_insee=l.com_code_insee_term
                    where lig_num like '%A%' order by to_number(rtrim(trim(lig_num),'AB')) ";
        // echo sqlLigParA;
        $sqlLigParB ="select lig_num,c.com_nom as depart ,b.com_nom as arrivee from vik_ligne l
                    join  vik_commune c on c.com_code_insee=l.com_code_insee_debu 
                    join  vik_commune b on b.com_code_insee=l.com_code_insee_term
                    where lig_num like '%B%' order by to_number(rtrim(trim(lig_num),'AB')) ";
       
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
                echo "<option value='$chemin/$input.php?ligne=".$tabA[$i]['LIG_NUM']."'>".$tabA[$i]["LIG_NUM"]." - ".$tabA[$i]['DEPART']." → ".$tabA[$i]['ARRIVEE']."</option>";
                $y= $i+1;
                echo "<option value='$chemin/$input.php?ligne=".$tabB[$i]['LIG_NUM']."'>".$tabB[$i]["LIG_NUM"]." - ".$tabB[$i]['DEPART']." → ".$tabB[$i]['ARRIVEE']."</option>";
            }
        }
        $conn = null;
    }

    
?>
