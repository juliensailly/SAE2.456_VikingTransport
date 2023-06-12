<!DOCTYPE html>
<?php

//include 'reservation_Ninscrit_ligne_unique.php';
include 'pdo_agile.php';
include 'visua_lignes.php';
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
        <h1>Réservation de trajet</h1>
        <h3>Choisir une ligne</h3>
        <select>
            <?php
            lirelignes();
            ?>
        </select>
        <h4>Choisir un arrêt de départ</h4>
        <h4>Choisir un arrêt de destination</h4>
        <button type="button">Valider</button>
    </body>
</html>