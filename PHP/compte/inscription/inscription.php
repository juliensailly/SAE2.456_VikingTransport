<?php
    $nb = 0;
    for($i=0;$i<sizeof($_POST);$i++){
        if(checkIfExist($_POST[$i])){
            $nb++;
        }
    }

    if($nb == sizeof($_POST)){
        echo "Veuillez remplir tous les champs";
    }else{
        echo "oui";
    }
    

    function checkIfExist($name){
        if(empty($name)) return true;
        return false;
    }
?>