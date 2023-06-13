<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Page d'accueil</title>
</head>
    <body>
        <h1>Réservation de voyage</h1>
        <h3>Choisir une ligne</h3>
        <form action="reservation_main.php" method="post">
            <select name="ligne">
                <option value="">--Selectionner une ligne</option>
                <?php
                
                    // $_POST['depp'] = null;
                    // $_POST['arrive'] = null;
                    // $_POST['ligne'] = null;

                    
                    $dep = $_POST['depp'];
                    $arrive = $_POST['arrive'];

                    include '../voir_lignes/visua_lignes.php';
                    lireLignes('', 'index');
                    include_once '../pdo_agile.php';
                    include '../param_connexion_etu.php';


                    $conn = OuvrirConnexionPDO($dbOracle,$db_usernameOracle,$db_passwordOracle);

                    $ligne = explode('=', $_POST['ligne'])[1];
                    if($ligne != "") $sql = "update lignum set numero = '$ligne'";

                    session_start();
                    $email = $_SESSION['email'];
                    
                    
                    $req = majDonneesPDO($conn, $sql);

                    $sql = "select depart from 
                    (
                        select com1.com_nom as depart, min(noe_heure_passage) as min_horaire
                        from vik_noeud noe
                        join vik_commune com1 on noe.com_code_insee=com1.com_code_insee
                        join vik_commune com2 on noe.com_code_insee_suivant=com2.com_code_insee
                        where $ligne
                        group by (com1.com_nom)
                    )
                    order by min_horaire";

                    $nbLigne =  LireDonneesPDO1($conn, $sql, $tab);
                    
                    if($nbLigne != 0){
                        for($i=0; $i<$nbLignes; $i++){
                            echo" <input type='radio' id='nom' name='depp'><label for='nom'>",$tab[$i]["DEPART"],"</label>";
                        }
                    }
                ?>

            </select>
            <input type="submit" value="Valider">
           
            <fieldset>
            <legend>Choisir un arrêt de départ :</legend>
                <?php
                    include "Reservation_table.php";
                    TableDepart($ligne);
                    $_SESSION['ligne'] = $ligne;
                ?>
        </fieldset>
        <fieldset>
            <legend>Choisir un arrêt d'arrivée :</legend>
            <?php
                TableArriver($ligne);
            ?>
            
        </fieldset>
        <Button><a href='../../index.php' style="color: black; text-decoration: none;">Retour</a></Button>
            
            <input type="submit" value="Valider">
            <?php
                if( $dep != "" && $arrive != ""){
                    $sql = "select cli_num from vik_client where cli_courriel = '$email'";
                    $num = LireDonneesPDO2($conn,$sql,$tab_num);

                
                    $sql = "SELECT nvl(MAX(res_num), 0) as maxi FROM vik_reservation";
                    $max = LireDonneesPDO2($conn,$sql,$tab);
                    $nb_res = $tab[0]["MAXI"] + 1;

                    $distance = "select depart, arrivee, noe_distance_prochain from 
                    (
                        select com1.com_nom as depart, com2.com_nom as arrivee, noe_distance_prochain, min(noe_heure_passage) as min_horaire
                        from vik_noeud noe
                        join vik_commune com1 on noe.com_code_insee=com1.com_code_insee
                        join vik_commune com2 on noe.com_code_insee_suivant=com2.com_code_insee
                        where lig_num='1A'
                        group by (com1.com_nom, com2.com_nom, noe_distance_prochain)
                    )
                    order by min_horaire";

                    $req = LireDonneesPDO2($conn, $distance, $tab);
                    $good = false;
                    $sum = 0;
                    $index = 0;
                    for($i=0; $i<$req; $i++){
                        if($tab[$i]['ARRIVEE'] != $arrive && !$good){
                            $sum += doubleval($tab[$i]["NOE_DISTANCE_PROCHAIN"]);
                        }
                        if($tab[$i]['ARRIVEE'] == $arrive){
                            $good = true;
                            $index = $i;
                        }
                    }

                    $sum += doubleval($tab[$index]["NOE_DISTANCE_PROCHAIN"]);

                    $sql = "select tar_num_tranche from vik_tarif where $sum between tar_min_dist and tar_max_dist";
                    $tranche = LireDonneesPDO2($conn, $sql, $tab);


                    $sql = "select tar_valeur from vik_tarif where tar_num_tranche = ".$tab[0]["TAR_NUM_TRANCHE"];
                    $nb = LireDonneesPDO2($conn, $sql, $tab2);

                    $sql = "insert into vik_reservation values ($num, $nb_res, ".$tab[0]["TAR_NUM_TRANCHE"].", sysdate, 0, ".$tab2[0]["TAR_VALEUR"].")";
                    $val = majDonneesPDO($conn, $sql);

                    $sql = "select com_code_insee from vik_commune where com_nom = '$dep'";
                    $depart = LireDonneesPDO2($conn, $sql, $tab);

                    $sql = "select com_code_insee from vik_commune where com_nom = '$arrive'";
                    $arr = LireDonneesPDO2($conn, $sql, $tab2);

                    //afficherTab($arrive);


                    $sql = "select numero from lignum";
                    $req = LireDonneesPDO2($conn, $sql, $tab3);

                    $sql = "insert into vik_correspondance values ('".$tab3[0]["NUMERO"]."', $num, $nb_res, ".$tab[0]["COM_CODE_INSEE"].", ".$tab2[0]["COM_CODE_INSEE"].", $sum, sysdate)";
                    $req = majDonneesPDO($conn, $sql);
                    $conn = null;
                    echo "<h4>Votre trajet est bien enregistré, votre numéro de commande est : $nb_res 🚍🚌</h4>";
                }
            ?>
            

            
        </form>
    </body>
    
</html>