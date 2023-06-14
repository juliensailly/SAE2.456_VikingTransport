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
    <?php
        $db_usernameOracle = "agile_1";
        $db_passwordOracle = "agile_1";
        $dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
    
        include_once '../../pdo_agile.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        session_start();
        $email = $_SESSION['email'];


        $sql = "select cli_nom, cli_prenom, cli_courriel, cli_date_naiss, cli_nb_points_ec, cli_nb_points_tot from vik_client where cli_courriel = '$email'";
        $req = LireDonneesPDO1($conn, $sql, $tab);

        $nom = $tab[0]['CLI_NOM'];
        $prenom = $tab[0]['CLI_PRENOM'];
        $email = $tab[0]['CLI_COURRIEL'];
        $datenaiss = $tab[0]['CLI_DATE_NAISS'];
        $nbpts = $tab[0]['CLI_NB_POINTS_EC'];
        $nbptstot = $tab[0]['CLI_NB_POINTS_TOT'];

        echo "<h1>Profil de $nom $prenom</h1>";
        echo "<p> Email : $email</p>";
        echo "<p> Date de naissance : $datenaiss </p>";
        echo "<p> Nb points : $nbpts</p>";
        echo "<p> Nb points totaux : $nbptstot</p>";

        $sql = "select cli_num from vik_client where cli_courriel = '$email'";
        $req = LireDonneesPDO1($conn, $sql, $tab);
        $num = $tab[0]['CLI_NUM'];

        echo "<h2>Trajet</h2>";

        $sql = "select cli_num as numero_de_client, res_num as numero_de_reservation, corr_distance as distance_de_trajet, co.com_nom as Ville_depart , cot.com_nom as Ville_arrivee
        from vik_correspondance cor
        join vik_client using (cli_num)
        join vik_commune co on cor.com_code_insee_depart = co.com_code_insee
        join vik_commune cot on cor.com_code_insee_arrivee = cot.com_code_insee
        where cli_num = $num";

        $req = LireDonneesPDO1($conn, $sql, $tab);
        echo "<table> <tr> 
        <th width=20%>Numero de client</th>
        <th width=20%>Numero de reservation</th>
        <th width=20%>distance du trajet</th>
        <th width=20%>ville de départ</th>
        <th width=20%>ville d'arrivee</th> 
        </tr>";
        if($req>0){
        for($i = 0; $i < count($tab); $i++){
            
            echo "<tr><td>". $tab[$i]['NUMERO_DE_CLIENT']."</td><td>". $tab[$i]['NUMERO_DE_RESERVATION']."</td><td>". $tab[$i]['DISTANCE_DE_TRAJET']."</td>
            <td>". $tab[$i]['VILLE_DEPART']."</td><td>". $tab[$i]['VILLE_ARRIVEE']."</td></tr>";
        }
    }
        echo"</table>";
        echo "<input type='button' value='Modifier' onclick='location.href=\"form.html\"'>";
        $conn = null;
        
    ?>
</body>
</html>