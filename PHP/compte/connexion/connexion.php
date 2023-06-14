<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/style.css">
    <title>Document</title>
</head>
<body>
<nav>
        <ul>
            <li><a href="../../../index.php">ACCUEIL</a></li>
            <li><a href="../../horairesLignes/horaires_ligne.php">HORAIRES</a></li>
            <li><a href="../../choix_manuel/trajet.php" class="reserv">RESERVER</a></li>
          </ul>
    </nav>
</body>
</html>

<?php
    
    echo "<a href='../../../index.php'>Retour à l'accueil</a> <br>";
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
            $_SESSION['email'] = $email;
            $sql = "select cli_num from vik_client where cli_courriel = '$email'";
            LireDonneesPDO1($conn,$sql,$tab_num);
            $_SESSION['num'] = $tab_num;
            echo "<a href='../modifier_profil/showProfil.php'>Informations</a> <br>";

            $sql = "update vik_client set cli_date_connec = sysdate where cli_courriel = '$email'";
            $req = majDonneesPDO($conn, $sql);

            echo "Connexion réussie";

            if($email == 'admin@admin.com' && $password == 'admin'){
                $_SESSION['admin'] = true;
                echo "<br>";
                echo "<a href='../../../admin.php'>Admin</a>";
            }else{
                $_SESSION['admin'] = false;
            }
            $conn = null;
        }else{
            echo "Mot de passe incorrect";
            echo "<br>";
            echo "<a href='formulaire.html'>Retour</a>";
            $conn = null;
        }
    }


    function checkInputEmail($input, $conn){
        $sql = "select cli_courriel from vik_client where cli_courriel = '$input'";
        $req = LireDonneesPDO2($conn, $sql, $tab);
        if($req == 0) return false;
        return true;
    }
?>