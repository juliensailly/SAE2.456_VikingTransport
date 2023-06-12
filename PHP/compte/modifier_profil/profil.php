<?php
include_once "pdo_agile.php";

// Récupération des paramètres de l'URL
$nom = $_GET["nom"];
$prenom = $_GET["prenom"];

// Vérification si les paramètres sont présents
if ($nom && $prenom) {
    // Appel de la fonction pour récupérer les données du compte
    $compte = visualiserCompte($nom, $prenom);

    // Vérification si le compte existe
    if ($compte) {
        // Affichage des informations du compte
        echo "<h1>Profil Utilisateur</h1>";
        echo "<p>Nom: " . $compte["cli_nom"] . "</p>";
        echo "<p>Prénom: " . $compte["cli_prenom"] . "</p>";
        echo "<p>Ville: " . $compte["cli_ville"] . "</p>";

        // Formulaire pour modifier les informations du compte
        echo "<h2>Modifier le profil</h2>";
        echo "<form method='POST' action='modifier_profil.php'>";
        echo "<input type='hidden' name='nom' value='" . $compte["cli_nom"] . "'>";
        echo "<input type='hidden' name='prenom' value='" . $compte["cli_prenom"] . "'>";
        echo "<label for='ville'>Ville:</label>";
        echo "<input type='text' name='ville' id='ville' value='" . $compte["cli_ville"] . "' required>";
        echo "<br><br>";
        echo "<button type='submit'>Enregistrer</button>";
        echo "</form>";
    } else {
        echo "Utilisateur non trouvé";
    }
} else {
    echo "Paramètres manquants";
}
?>
