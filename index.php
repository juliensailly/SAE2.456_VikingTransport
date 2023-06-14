<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Page d'accueil</title>
    
</head>

<body>
<nav>
    <ul>
      <?php
        session_start();
        if(!isset($_SESSION['email'])){
          echo "<li><a href=\"PHP/compte/connexion/formulaire.html\">CONNEXION</a></li>";
          echo "<li><a href=\"PHP/compte/inscription/formulaire.html\">INSCRIPTION</a></li>";
        }
      ?>
      <li><a href="PHP/horairesLignes/horaires_ligne.php">HORAIRES</a></li>
      <?php
        if(isset($_SESSION['email']) && $_SESSION['email'] != null){
          echo "<li><a href=\"PHP/compte/modifier_profil/form.html\">MODIFIER PROFIL</a></li>";
        }
      ?>
      
      <li><a href="PHP/statistiques/statistiques.php">STATISTIQUES</a></li>
      <li><a href="PHP/choix_manuel/trajet.php">RESERVER</a></li>
      <?php
        if(isset($_SESSION['admin'])){
          if($_SESSION['admin'] == true){
                    echo "<li><a href=\"admin.php\">ADMIN</a></li>";
            }
        }
      ?>
      <?php
        if(isset($_SESSION['email'])){
          echo "<li><a href=\"PHP/compte/deconnexion/deconnexion.php\">Deconnexion</a></li>";
        }
      ?>
    </ul>
  </nav>
</body>
</html>