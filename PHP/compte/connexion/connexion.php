<?php
    include_once '../../pdo_agile.php';
    $db_usernameOracle = "agile_1";
    $db_passwordOracle = "agile_1";
    $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
    $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

    $email = $_POST['email'];
    $password = $_POST['password'];

    echo "aaa";
    if(!checkInputEmail($email, $conn)){
        echo "Email incorrect";
        return;
    }else{
        if(password_verify($password, CRYPT_SHA256)){
            echo "Connexion réussie";
        }
    }


    function checkPassword(){

    }

    function checkInputEmail($input, $conn){
        $sql = "select cli_courriel from vik_client where cli_courriel = '$input'";
        $req = LireDonneesPDO2($conn, $sql, $tab);
        if($req == 0) return false;
        return true;
    }
?>