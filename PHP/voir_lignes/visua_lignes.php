

<?php

    function lireLignes(){
        include_once "../pdo_agile.php";

        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        $sql = "Select * from vik_ligne";
        $nbLignes = LireDonneesPDO1($conn,$sql,$tab);

    
        if($nbLignes == 0)
                echo "erreur";
            else{
                for($i=0; $i<$nbLignes; $i++){
                    echo "<option value='option$i'>",$tab[$i]["LIG_NUM"],"</option>";
                }
            }
    }

    
?>



