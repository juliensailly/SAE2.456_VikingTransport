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
        <form action="reservation.php" method="post">
            <select name="ligne">
                <option value="">--Selectionner une ligne</option>
                <?php
                    include '../voir_lignes/visua_lignes.php';
                    lireLignes('', 'index');
                ?>
            </select>
            <input type="submit" value="Valider">
        <fieldset>
            <legend>Choisir un arrêt de départ :</legend>
        </fieldset>
        <fieldset>
            <legend>Choisir un arrêt d'arrivée :</legend>
            
        </fieldset>
            <input type="submit" value="Valider">
            <input type="submit" value="Annuler">
        </form>
        
        
    </body>
    
</html>