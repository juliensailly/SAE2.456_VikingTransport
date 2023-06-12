<?php
    include_once "param_connexion_etu.php";
    include_once "pdo_agile.php";

    $db_usernameOracle = "agile_1";
	$db_passwordOracle = "agile_1"; 
	$dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";

    $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
    $sql = "Select * from vik_ligne";
    $nbLignes = LireDonneesPDO1($conn,$sql,$tab);

    if($nbLignes == 0)
            echo "erreur";
        else{
            for($i=0; $i<$nbLignes; $i++){
                echo $tab[$i]["LIG_NUM"],"<br>";
            }
        }
?>

