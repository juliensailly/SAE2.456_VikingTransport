<?php
include_once '../pdo_agile.php';
include '../param_connexion_etu.php';


$conn = OuvrirConnexionPDO($dbOracle, $db_usernameOracle, $db_passwordOracle);
if (!isset($_GET['email']) || empty($_GET['email'])) {
    echo "<p>erreur vous n'avez pas renseigné l'adresse mail</p>";
    echo "<a href='voir_comptes.php'>Retour</a>";
} else {
    $email = $_GET['email'];
    $sql = "select cli_num from vik_client where cli_courriel = '$email'";
    $req = LireDonneesPDO1($conn, $sql, $tab_num);


    $nom = $_GET['nom'];
    $prenom = $_GET['prenom'];
    $date_naiss = $_GET['datenaiss'];
    $password = $_GET['password'];
    $error = 0;

    if (isset($nom) && !empty($nom)) {
        $error = update($conn, $nom, 'cli_nom', $tab_num[0]['CLI_NUM']);
    }
    if (isset($prenom) && !empty($prenom)) {
        $error = update($conn, $prenom, 'cli_prenom', $tab_num[0]['CLI_NUM']);
    }
    if (isset($email) && !empty($email)) {
        $error = updateEmail($conn, $email, $tab_num[0]['CLI_NUM']);
    }
    if (isset($date_naiss) && !empty($date_naiss)) {
        $error = updateDate($conn, $date_naiss, $tab_num[0]['CLI_NUM']);
    }



    if (isset($password) && useRegex($password) && !empty($password)) {
        $password_hashed = password_hash($password, CRYPT_SHA256);
        $sql = "update vik_client set cli_password = '$password_hashed' where cli_num = '" . $tab_num[0]['CLI_NUM'] . "'";
        $req = majDonneesPDO($conn, $sql);
        if ($req == 0)
            $error = -1;
        else
            $error = 0;
    }

    if ($error == -1) {
        echo "<h1>Modification échouée</h1>";
        echo "<a href='showProfil.php'>Retour</a>";
    } else {
        echo "<h1>Modification réussie</h1>";
        echo "<a href='voir_comptes.php'>Retour</a>";
    }
}
$conn = null;

function update($conn, $input, $val, $num)
{
    if (isset($input) && useRegex($input)) {
        $sql = "update vik_client set $val = '$input' where cli_num = '$num'";
        $req = majDonneesPDO($conn, $sql);
        if ($req == 0)
            return -1;
        else
            return 0;
    }
}

function updateDate($conn, $input, $num)
{
    if (isset($input)) {
        $sql = "update vik_client set cli_date_naiss = to_date('$input', 'yyyy/mm/dd') where cli_num = '$num'";
        $req = majDonneesPDO($conn, $sql);
        if ($req == 0)
            return -1;
        else
            return 0;
    }
}

function updateEmail($conn, $input, $num)
{
    if (isset($input) && useRegexEmail($input)) {
        if (!isEmailExist($input, $conn)) {
            $sql = "update vik_client set cli_courriel = '$input' where cli_num = '$num'";
            $req = majDonneesPDO($conn, $sql);
            $_SESSION['email'] = $input;
            if ($req == 0)
                return -1;
            else
                return 0;
        }
    }
}



function useRegexEmail($input)
{
    $regex = '/^[a-zA-Z0-9_.]+@[a-zA-Z0-9_.]+\.[a-zA-Z0-9_]+$/';
    return preg_match($regex, $input);
}

function useRegex($input)
{
    $regex = '/^[a-zA-Z0-9_]+$/';
    return preg_match($regex, $input);
}

function isEmailExist($input, $conn)
{
    $sql = "select cli_courriel from vik_client where cli_courriel = '$input'";
    $req = LireDonneesPDO2($conn, $sql, $tab);
    if ($req == 0)
        return false;
    return true;
}
?>