<!DOCTYPE html>
<?php

include 'Reservation_table.php';
//include 'visua_lignes.php';
?>
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
        <select>
            <?php
            lirelignes();
            ?>
        </select>
        <fieldset>
            <legend>Choisir un arrêt de départ :</legend>
            <?php
            TableDepart();
            ?>
        </fieldset>
        <fieldset>
            <legend>Choisir un arrêt d'arrivée :</legend>
            <?php
        TableArriver();
        ?>
        </fieldset>
        
        <button type="button">Valider</button>
        <button type="button">Annuler</button>
        
    </body>
    
</html>