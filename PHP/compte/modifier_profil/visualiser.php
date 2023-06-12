<?php
    include_once "pdo_agile.php";
    //$connexion = mysqli_connect($db_usernameOracle, $db_passwordOracle, $dbOracle);

    function visualiserCompte($nom, $prenom) {
        $nom = mysqli_real_escape_string($connexion, $nom);
        $prenom = mysqli_real_escape_string($connexion, $prenom);

        $sql = "SELECT * FROM sae.vik_client WHERE cli_nom = '$nom' AND cli_prenom = '$prenom'";

        $resultat = mysqli_query($connexion, $sql);

        if (mysqli_num_rows($resultat) > 0) {
            $donnees = mysqli_fetch_assoc($resultat);
            return $donnees;
        } else {
            return null;
        }
        mysqli_close($connexion);
    }

    function visualiserTrajet($ville_debut, $ville_fin) {
        $ville_debut = mysqli_real_escape_string($connexion, $ville_debut);
        $ville_fin = mysqli_real_escape_string($connexion, $ville_fin);

        $sql = "SELECT * FROM sae.vik_commune commune JOIN sae.vik_ligne debut_commune ON commune.com_code_insee = debut_commune.com_code_insee_debu JOIN sae.vik_ligne fin_commune ON commune.com_code_insee = fin_commune.com_code_insee_term  WHERE debut_commune.com_nom = '$               ' AND fin_commune.com_nom = '$                '";

        $resultat = mysqli_query($connexion, $sql);

        if (mysqli_num_rows($resultat) > 0) {
            $donnees = mysqli_fetch_assoc($resultat);
            return $donnees;
        } else {
            return null;
        }
        
    }

    function visualiserPoints($cli_nom, $cli_prenom) {
        $cli_nom = mysqli_real_escape_string($connexion, $cli_nom);
        $cli_prenom = mysqli_real_escape_string($connexion, $cli_prenom);

        $sql = "SELECT * FROM sae.vik_commune commune JOIN sae.vik_ligne debut_commune ON commune.com_code_insee = debut_commune.com_code_insee_debu JOIN sae.vik_ligne fin_commune ON commune.com_code_insee = fin_commune.com_code_insee_term  WHERE debut_commune.com_nom = '$               ' AND fin_commune.com_nom = '$                '";

        $resultat = mysqli_query($connexion, $sql);

        if (mysqli_num_rows($resultat) > 0) {
            $donnees = mysqli_fetch_assoc($resultat);
            return $donnees;
        } else {
            return null;
        }
        
    }
    mysqli_close($connexion);
    




?>


    
