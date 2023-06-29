<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$qs = "";
	

	
	if ($action = valider("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";

		// ATTENTION : le codage des caractères peut poser PB 
		// si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		/*
		if ($action != "Connexion") 
			securiser("login");
		*/

		// Un paramètre action a été soumis, on fait le boulot...
		switch($action)
		{
			
			// Connexion //////////////////////////////////////////////////
			case 'id':
				$response=json_encode($_SESSION["idUser"]);
    		echo $response;

			case 'deconnexion' :
						session_destroy();	
					$qs="?view=connexion";		
			break; 
			
			case 'Connexion' :
				// On verifie la presence des champs login et passe
				if ($login = valider("login"))
				if ($passe = valider("passe"))
				{
					// On verifie l'utilisateur, et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					verifUser($login,$passe); 	
				}

				// On redirigera vers la page index automatiquement
			break;

			case 'Inscription' :
				if($pseudo= valider("pseudo"))
				if($password=valider("password"))
				if($role=valider("role"))
				{
				$reponse=createNewUser($pseudo,$password,$role);
				}
				$qs="?view=Inscription&reponse=$reponse";	


			break;

			case 'Associer' :
				$idUser = valider("idUser");
				$idGroup = valider("idGroup");
				AjouterEleveGroupe($idUser,$idGroup);	
				$qs="?view=GererGroupes";	

			break;

			case 'Associer à ce groupe' :
				$idUser = valider("idUser2");
				$idGroup = valider("idGroup2");
				AjouterEleveGroupe($idUser,$idGroup);	
				$qs="?view=GererGroupe&reponse=$idGroup";	

			break;

			case 'Créer Groupe' :
				$description = valider("description");
				CreerGroupe($description);
				$qs="?view=GererGroupes";	

			break;

			case 'Modifier ce groupe' :
				$reponse=valider("idGroup2");
				$qs="?view=GererGroupe&reponse=$reponse";

			break;

			case 'Supprimer ce groupe' :
				$idGroup=valider("idGroup3");
				SupprimerGroupe($idGroup);
				$qs="?view=GererGroupes";

			break;

			case 'Retirer de ce groupe' :
				$idUser=valider("idUser3");
				$idGroup=valider("idGroup4");
				SupprimerEleveGroupe($idUser,$idGroup);
				$qs="?view=GererGroupe&reponse=$idGroup";

			break;

			case 'Retourner au menu précedent' :
				$qs="?view=GererGroupes";

			break;
			
		
		

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments

header("Location:" . $urlBase . $qs);
	//qs doit contenir le symbole '?'
	
	// On écrit seulement après cette entête
	ob_end_flush();

}
?>