<?php
// Code PHP pour traiter le formulaire de modification de profil

// Vérifier si le formulaire de modification a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire et effectuer les opérations de mise à jour du profil
    // ...

    // Rediriger vers la page de profil après la sauvegarde
    header("Location: profil.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier le profil</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="button-wrapper">
        <button onclick="openModifierProfil()">Modifier le profil</button>
    </div>

    <script>
        function openModifierProfil() {
            window.open("modifier_profil.php", "_blank");
        }
    </script>
</body>
</html>

