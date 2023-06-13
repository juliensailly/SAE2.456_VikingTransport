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
    <form method="get">
        <select name="menuLigne" id="menuLigne" onchange="location = this.value;">
            <option value=''>--choisir votre ligne--</option>
            <?php
                include '../voir_lignes/visua_lignes.php';
                lireLignes('trajet','.');
            ?>
        </select>
    </form>
    <form method="get" >
        <select name="menuVilleDeb" id="menuVilleDeb" onchange="location = this.value;">

            <?php
                include "choix_manuel.php";
                if(isset($_GET['ligne']))
                    afficherVilleDebut($_GET['ligne']);
            ?>
        </select>
        <select name="menuVilleTerm" id="menuVilleTerm" onchange="location = this.value;">
            <?php
                include "choix_ville_fin.php";
                if(isset($_GET['villedeb']))
                    afficherVilleTerm($_GET['ligne'], $_GET['villedeb']);
            ?>
        </select>
    </form>   

</body>
</html>


