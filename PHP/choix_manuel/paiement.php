<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/style.css">
    <?php
    session_start();
    if (isset($_GET['numRes'])) {
        echo "<title>Paiement de la réservation n°" . $_GET['numRes'] . "</title>";
    } else {
        echo "<title>Paiement de la réservation</title>";
    }
    ?>
</head>

<body>
    <?php
    if (isset($_GET['numRes'])) {
        include_once '../pdo_agile.php';
        include '../param_connexion_etu.php';
        $conn = OuvrirConnexionPDO($dbOracle, $db_usernameOracle, $db_passwordOracle);
        $sql = "select res_prix_tot from vik_reservation where res_num = " . $_GET['numRes'];
        $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
        $prix = $tab[0]['RES_PRIX_TOT'];
        echo "<h1>Paiement de la réservation : $prix €</h1>";
    } else {
        echo "<h1>Paiement de la réservation</h1>";
    }
    echo "|" . $_SESSION['num'] . "|";
    ?>

    <fieldset>
        <legend>Informations de paiement</legend>
        <?php
        echo "<form action=\"paiement.php\" method=\"post\" class=\"paiementForm\">";
        ?>
        <div class="formElement">
            <label for="numCB">Numéro de carte bancaire</label>
            <input type="number" name="numCB" id="numCB" required>
        </div>
        <div class="formElement">
            <label for="dateExp">Date d'expiration</label>
            <input type="month" name="dateExp" id="dateExp" required>
        </div>
        <div class="formElement">
            <label for="codeSecu">Code de sécurité</label>
            <input type="number" name="codeSecu" id="codeSecu" required>
        </div>
        <div class="formElement">
            <?php
            if (isset($_GET['numRes'])) {
                echo "<label for=\"points\">Voulez vous utiliser les points de votre compte ";
                include_once '../pdo_agile.php';
                include '../param_connexion_etu.php';
                $conn = OuvrirConnexionPDO($dbOracle, $db_usernameOracle, $db_passwordOracle);
                $sql = "SELECT cli_num, cli_nb_points_tot, res_num
                    FROM vik_client
                    JOIN vik_reservation USING (cli_num)
                    WHERE res_num = " . $_GET['numRes'];
                $nbLignes = LireDonneesPDO1($conn, $sql, $tab);
                $nbPoints = $tab[0]['CLI_NB_POINTS_TOT'];
                echo "($nbPoints) :</label>";
                $conn = null;
                if ($nbPoints == 0) {
                    echo "<input type=\"radio\" name=\"points\" id=\"ouiPoints\" value=\"ouiPoints\" disabled>";
                    echo "<label for=\"ouiPoints\">Oui</label>";
                } else {
                    echo "<input type=\"radio\" name=\"points\" id=\"ouiPoints\" value=\"ouiPoints\">";
                    echo "<label for=\"ouiPoints\">Oui</label>";
                }
                echo "<input type=\"radio\" name=\"points\" id=\"nonPoints\" value=\"nonPoints\">";
                echo "<label for=\"nonPoints\">Non</label>";
            }

            ?>
        </div>
        <input type="submit" value="Payer">
        </form>
    </fieldset>

    <?php
    if (isset($_POST['numCB']) && isset($_POST['dateExp']) && isset($_POST['codeSecu']) && $_POST['numCB'] != "" && $_POST['dateExp'] != "" && $_POST['codeSecu'] != "") {
        echo "<p>Le paiement a bien été effectué</p>";
        if (isset($_POST['points'])) {
            if ($_POST['points'] == "ouiPoints") {

                echo "<p>Les points ont bien été utilisés</p>";
            } else {
                echo "<p>Les points n'ont pas été utilisés</p>";
            }
        }
    }
    ?>
</body>

</html>