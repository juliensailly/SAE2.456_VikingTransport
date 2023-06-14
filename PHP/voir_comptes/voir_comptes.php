<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="../../CSS/style.css">
    
</head>

<body>
<nav>
        <ul>
            <li><a href="../../../index.php">ACCUEIL</a></li>
            <li><a href="../../horairesLignes/horaires_ligne.php">HORAIRES</a></li>
            <li><a href="../../choix_manuel/trajet.php" class="reserv">RESERVER</a></li>
          </ul>
    </nav>
    <a href="../../index.php">Retour à l'accueil</a>
    <h1>Liste des clients</h1>
    <form method="get">
        <select name="" id="" onchange="location=this.value;">
        <?php
            include_once '../pdo_agile.php';
            include '../param_connexion_etu.php';
            $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
            $erreur = false;
            $sql = "select cli_nom,cli_prenom,cli_num from vik_client order by cli_num asc";
            $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
            if ($nbLignes == 0) {
                $erreur = true;
            }
            if (!$erreur) {
                echo "<option value=''selected>--Choisir un client--</option>";
                for ($i = 0; $i < $nbLignes; $i++) {
                    if (str_replace(" ", "", $tab[$i]['CLI_NUM']) == $_GET['client_num'])
                        echo "<option value='./voir_comptes.php?client_num=" .$tab[$i]['CLI_NUM']."'selected>". $tab[$i]['CLI_NUM'] . " : " . $tab[$i]["CLI_NOM"] . " " . $tab[$i]['CLI_PRENOM'] . "</option>";
                    else{
                        echo "<option value='./voir_comptes.php?client_num=" .$tab[$i]['CLI_NUM']."'>". $tab[$i]['CLI_NUM'] . " : " . $tab[$i]["CLI_NOM"] . " " . $tab[$i]['CLI_PRENOM'] . "</option>";
                    }
                }
            }
            $conn = null;
        ?>
        </select>
    </form>
    <?php
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';
        include './delete_compte.php';
        $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);
        if(isset($_GET['client_num'])) {
            $sql = "select cli_num, cli_nom, cli_prenom, cli_courriel, cli_ville, cli_date_connec from vik_client where cli_num=" . $_GET['client_num'] . "order by cli_num asc";
            $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
            if($nbLignes == 0) {
                echo "<p>Il n'y a pas de client</p>";
            } else {
                echo "<table> <tr> <th>Numéro</th> <th>Nom</th> <th>Prenom</th> <th>Ville</th> <th>Courriel</th> <th>Date de connexion</th> </tr>";
                for ($i = 0; $i < $nbLignes; $i++) {
                    echo "<tr> <td>" . $tab[$i]["CLI_NUM"] . "</td> <td name='client_nom'>" . $tab[$i]["CLI_NOM"] . "</td> <td>" . $tab[$i]["CLI_PRENOM"] . "</td> <td>" . $tab[$i]["CLI_VILLE"] . "</td> <td>" . $tab[$i]["CLI_COURRIEL"] . "</td> <td>" . $tab[$i]["CLI_DATE_CONNEC"] . "</td> </tr>";
                }
                echo "</table>";
                echo "<a href='../voir_reservation/voir_reservation.php?client_num=" . $_GET['client_num'] . "&client_nom=" . $tab[0]["CLI_NOM"] . "&client_prenom=" . $tab[0]["CLI_PRENOM"] ."'>Voir Reservation</a>";
                echo "<a href='./form.php?email=" . $tab[0]["CLI_COURRIEL"] . "'>Modifier Profil</a>";
                echo "<a href='./voir_comptes.php?client_num=" . $_GET['client_num'] ."&delete_button=1 '>Supprimer Client</a>";
            }
            if(isset($_GET['delete_button'])) {
                supprimerCompte($_GET['client_num']);
            }
        }
        $conn = null;
    ?>
</body>
</html>