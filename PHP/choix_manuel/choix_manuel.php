<?php
    function ajouterMenuDeroulantCommune(){
       
        $cheminParent = dirname(__DIR__);
        include_once $cheminParent . '/pdo_agile.php';
        include $cheminParent . '/param_connexion_etu.php';
        $conn = ouvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        $sqlReq1="select com_nom from vik_commune";
        $nbLignes = LireDonneesPDO1($conn,$sqlReq1,$tab);
        $erreur = false;
        if($nbLignes == 0){
            $erreur=true;
        }
        if(!$erreur) {
            for($i = 0; $i < $nbLignes; $i++) {
                echo "<option value='option$i'>",$tab[$i]["COM_NOM"],"</option>","<br>";
            }
        }
    }






$sqlReq5="select * from vik_ligne
    where com_code_insee_debu =
    (
        select com_code_insee from vik_commune where com_nom = 'Gamaches'
    ) and com_code_insee_term = 
    (
        select com_code_insee from vik_commune where com_nom = 'Caen'
    )";
?>