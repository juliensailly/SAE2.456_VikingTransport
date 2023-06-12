<!--  E.Porcq	16a.php 26/09/2009 maj 5/08/2017 Liste déroulante dynamique avec oci-->


<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Chargement dynamique de liste en PHP</title>
  </head>
  <body>
    <?php
		include ("fonc_oracle.php");
		include ("util_chap11.php");
		include ("util.php");
		include_once 'info_conn.php';

		// ce code ne doit pas être dans le <select> … </select>
		//------------------------------------------------------------------------------------------
		$conn = OuvrirConnexionOCI($infoConn['login'], $infoConn['mdp'],$infoConn['instanceOCI']);

		$req = 'SELECT * FROM prof.vt_coureur where rownum < 10 order by nom';
		$cur = PreparerRequeteOCI($conn,$req);
		$res = ExecuterRequeteOCI($cur);
		$nbLignes = LireDonneesOCI1($cur,$tab); // Attention, pas &$tab
		//afficherTab($tab); // pour vérifier que cela a fonctionné et le sens de la matrice	
		FermerConnexionOCI($conn);
		//------------------------------------------------------------------------------------------

		if (!empty($_POST))
		{
			if (isset($_POST['coureur']))
			{
				$cour = $_POST['coureur'];
				echo ("Le Coureur a été $cour sélectionné");
			}
		}
		else
		  include ("16.htm");
    ?>   	
  </body>
</html>

<!-- on peut sélectionner un nom est récupérer le numéro du coureur -->