<?php
    session_start();
    session_destroy();
    echo "<h1>Déconnexion réussie</h1>";
    echo "<a href='../../../index.php'>Retour</a>";
?>