<?php
function TrajetinterLigne(){
    include_once "../pdo_agile.php";
    include_once "visua_lignes.php";
    
    if(lireLignes() == 0){
        echo "Cette ligne n'existe pas";
    }else{
        lireLignes();

    }
}

?>