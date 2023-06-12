<?php
    
    $db_usernameOracle = "agile_1";
    $db_passwordOracle = "agile_1";
    $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
    
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
        include_once '../../pdo_agile.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

        if(isEmailExist($_POST["email"], $conn)){
            echo "L'email existe déjà";
        }else{
            $sql = "SELECT nvl(MAX(CLI_NUM), 0) as maxi FROM vik_client";
            $max = LireDonneesPDO2($conn,$sql,$tab);
            $nb = $tab[0]["MAXI"] + 1;

            $date_good = "to_date('$datenaiss', 'yyyy/mm/dd')";

            $password = password_hash($password, CRYPT_SHA256);
            
            $sql = "INSERT INTO vik_client (CLI_NUM, CLI_NOM, CLI_PRENOM, CLI_COURRIEL, CLI_PASSWORD, CLI_DATE_NAISS) 
                VALUES ('$nb', '$nom', '$prenom', '$email', '$password', $date_good)";
            $nbLignes = majDonneesPDO($conn,$sql);
            

            if($nbLignes == 0)
                echo "erreur";
            else{
                echo "Votre compte a bien été créé";
            }
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

    function isEmailExist($input, $conn){
        $sql = "select cli_courriel from vik_client where cli_courriel = '$input'";
        $req = LireDonneesPDO2($conn, $sql, $tab);
        if($req == 0) return false;
        return true;
    }
?>