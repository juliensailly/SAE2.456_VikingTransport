<?php
    
    if(checkIfExist($_POST)){
        echo "Veuillez renseigner tout les champs";
    }else{
        echo "ok";
    }

    function checkIfExist($tab){
        if(!isset($tab["nom"]) || !isset($tab["prenom"]) 
        || !isset($tab["email"]) || !isset($tab["password"]) 
        || !isset($tab["datenaiss"])){
            return false;
        }
        if(!useRegex($tab["nom"]) || !useRegex($tab["prenom"])
        || !useRegex($tab["datenaiss"]) || !useRegex($tab["password"]) 
        || !useRegex($tab["email"])){
            return false;
        }
        return true;
    }

    

    function useRegex($input) {
        $regex = '/[A-Za-z0-9]+\\$\\*&é"#\\{[^}]*\\}\\+°%!:;,/i';
        return preg_match($regex, $input);
    }
?>