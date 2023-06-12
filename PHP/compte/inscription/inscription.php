<?php
    
    if(checkIfExist($_POST) == -1){
        echo "Veuillez renseigner tout les champs";
    }else if(checkIfExist($_POST) == -2){
        echo "Veuillez renseigner tout les champs avec des lettres ou des chiffres";
    }else{
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $datenaiss = $_POST["datenaiss"];
        include_once 'PHP\pdo_agile.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        $sql = "INSERT INTO vik_client (CLI_NOM, CLI_PRENOM, CLI_COURRIEL, CLI_PASSWORD, CLI_DATENAISS) VALUES ('$nom', '$prenom', '$email', '$password', '$datenaiss')";
        $nbLignes = majDonneesPDO($conn,$sql);
        if($nbLignes == 0)
            echo "erreur";
        else{
            echo "Inscription réussie";
        }
    }

    function checkIfExist($tab){
        if(isset($tab["nom"]) && isset($tab["prenom"]) && isset($tab["email"]) 
            && isset($tab["password"]) && isset($tab["datenaiss"])){
                if(useRegex($tab["nom"]) && useRegex($tab["prenom"]) && useRegexEmail($tab["email"])) return 0;
                else return -2; 
        }
        return -1;
    }
    

    function useRegex($input) {
        $regex = '/^[a-zA-Z0-9_]+$/';
        return preg_match($regex, $input);
    }

    function useRegexEmail($input){
        $regex = '/^[a-zA-Z0-9_]+@[a-zA-Z0-9_]+\.[a-zA-Z0-9_]+$/';
        return preg_match($regex, $input);
    }
?>