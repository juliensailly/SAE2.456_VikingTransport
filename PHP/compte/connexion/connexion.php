<?php
    include_once '../../pdo_agile.php';
    $db_usernameOracle = "agile_1";
    $db_passwordOracle = "agile_1";
    $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
    $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!checkInputEmail($email, $conn)){
        echo "Email incorrect";
        echo "<br>";
        echo "<a href='formulaire.html'>Retour</a>";
    }else{
        $sql = "select cli_password from vik_client where cli_courriel = '$email'";
        $req = LireDonneesPDO2($conn, $sql, $tab);
        if(password_verify($password, $tab[0]['CLI_PASSWORD'])){
            echo "Connexion réussie";
        }else{
            echo "Mot de passe incorrect";
            echo "<br>";
            echo "<a href='formulaire.html'>Retour</a>";
        }
    }


    function checkInputEmail($input, $conn){
        $sql = "select cli_courriel from vik_client where cli_courriel = '$input'";
        $req = LireDonneesPDO2($conn, $sql, $tab);
        if($req == 0) return false;
        return true;
    }
?>