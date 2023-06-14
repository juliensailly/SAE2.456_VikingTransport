<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <a href='../../index.php'>Retour à l'accueil</a>
    <?php
    echo "<form action='modifier_profil.php?email = " . $_GET['email'] . "' method='get'>";
    ?>
        <h1>Modifier votre profil</h1>
        <p>Remplissez les champs ci-dessous pour modifier votre profil</p>
        <p>Si vous ne souhaitez pas modifier un champ, laissez-le vide</p>

        <label for="">Prenom : </label><input type="text" name="prenom" placeholder="Prenom">
        <br>
        <label for="">Nom : </label><input type="text" name="nom" placeholder="Nom">
        <br>
        <label for="">Email : </label><input type="text" name="email" placeholder="Email">*
        <br>
        <label for="">Date de Naissance : </label><input type="date" name="datenaiss" placeholder="Date de naissance">
        <br>
        <label for="">Mot de passe : </label><input type="password" name="password" placeholder="Mot de passe">
        <br>
        <input type="submit" value="Submit">
        <input type="submit" value="Retour">
    </form>
</body>
</html>