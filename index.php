<?php
session_start();
?>

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
  <nav >
    <ul style="display: flex; align-items: center;">
     <img src="Logo-SNCF-Connect.png" style="width: 10%">
      <?php
      if (!isset($_SESSION['email'])) {
        echo "<li><a href=\"PHP/compte/connexion/formulaire.html\">CONNEXION</a></li>";
        echo "<li><a href=\"PHP/compte/inscription/formulaire.html\">INSCRIPTION</a></li>";
      }
      ?>
      <li><a href="PHP/horairesLignes/horaires_ligne.php">HORAIRES</a></li>
      <?php
      if (isset($_SESSION['email']) && $_SESSION['email'] != null) {
        echo "<li><a href=\"PHP/compte/modifier_profil/form.html\" class=\"modif\">MODIFIER PROFIL</a></li>";
        echo "<li><a href=\"PHP/compte/modifier_profil/showProfil.php\" class=\"show\">VOIR PROFIL</a></li>";
      }
      ?>
      <li><a href="PHP/choix_manuel/trajet.php" class="reserv">RESERVER</a></li>
      <?php
      if (isset($_SESSION['admin'])) {
        if ($_SESSION['admin'] == true) {
          echo "<li><a href=\"admin.php\" class=\"admin\">ADMIN</a></li>";
        }
      }
      ?>
      <?php
      if (isset($_SESSION['email'])) {
        echo "<li><a href=\"PHP/compte/deconnexion/deconnexion.php\" class=\"deco\">Deconnexion</a></li>";
      }
      ?>
    </ul>
  </nav>
  <img src="photoscam.png" alt="image bus" id="bus">

  <p> Nous sommes une entreprise dévouée qui gère un vaste réseau de bus reliant plus de 80 villes en Normandie. Que
    vous soyez un habitant local, un touriste curieux ou un voyageur d'affaires, nous sommes là pour vous offrir des
    solutions de transport fiables, pratiques et confortables.</p>

  <p>Chez Viking Transport, nous comprenons l'importance de voyager en toute tranquillité. C'est pourquoi nous mettons
    tout en œuvre pour assurer des trajets sécurisés et agréables à nos passagers. Nos bus modernes et bien entretenus
    sont équipés de toutes les commodités nécessaires, tels que des sièges confortables, la climatisation et des
    connexions Wi-Fi, pour rendre votre voyage aussi agréable que possible.</p>

  <p>Notre équipe de chauffeurs expérimentés et courtois est là pour vous accueillir à bord et vous offrir un service
    amical et professionnel. Ils connaissent les routes de la Normandie comme leur poche et sont déterminés à vous faire
    arriver à destination en toute sécurité et à l'heure.</p>

  <p>Explorez notre site pour découvrir nos lignes, nos horaires, nos tarifs et bien plus encore.</p>

  <p>Choisissez Viking Transport pour des déplacements en toute tranquillité et découvrez la beauté de la Normandie à
    bord de nos bus de qualité. Nous nous réjouissons de vous accueillir à bord et de vous offrir une expérience de
    voyage exceptionnelle !</p>

  <p>L'équipe Viking Transport</p>


  <style>
    img {
      width: 50%;
      left;
      margin-right: 10px;
    }

    #bus {
      float: left;
    }

    p {
      font-family: 'Roboto';
      left;
    }
  </style>
</body>

</html>