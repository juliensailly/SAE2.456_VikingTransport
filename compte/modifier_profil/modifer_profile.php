<?php

// Connexion à la base de données (remplacez les valeurs par vos propres informations de connexion)
$db_usernameOracle = "agile_1";
$db_passwordOracle = "agile_1"; 
$dbOracle = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";

$conn = new mysqli( $db_passwordOracl, $db_passwordOracle, $dbOracle);
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

function modifierProfil($idUtilisateur, $nouveauNom, $nouvelEmail) {
    global $conn;

    // Préparer la requête SQL pour mettre à jour le profil utilisateur
    $stmt = $conn->prepare("UPDATE utilisateurs SET nom = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nouveauNom, $nouvelEmail, $idUtilisateur);

    // Exécuter la requête de mise à jour du profil
    if ($stmt->execute()) {
        // Requête pour récupérer le nombre de points total
        $stmtPoints = $conn->prepare("SELECT cli_nb_points_tot FROM vik_client WHERE id = ?");
        $stmtPoints->bind_param("i", $idUtilisateur);
        $stmtPoints->execute();
        $stmtPoints->bind_result($nombrePoints);

        // Récupérer le nombre de points total
        if ($stmtPoints->fetch()) {
            echo "Profil utilisateur modifié avec succès ! Nombre de points total : " . $nombrePoints;
        } else {
            echo "Erreur lors de la récupération du nombre de points.";
        }

        // Fermer le statement de récupération des points
        $stmtPoints->close();
    } else {
        echo "Erreur lors de la modification du profil utilisateur : " . $stmt->error;
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
}

// Utilisation de la fonction pour modifier un profil utilisateur et récupérer le nombre de points total
modifierProfil(1, "Nouveau nom", "nouveau@email.com");

?>
