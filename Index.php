<?php
session_start();
if (isset($_SESSION["idUser"])){
<<<<<<< Updated upstream
$id=$_SESSION["idUser"];
echo ("<script>idUser={$id};
console.log(idUser);</script>");
=======
    $id=$_SESSION["idUser"];
    echo ("<script>idUser={$id};
    console.log(idUser);</script>");
>>>>>>> Stashed changes
}
/*
Cette page génère les différentes vues de l'application en utilisant des templates situés dans le répertoire "templates". Un template ou 'gabarit' est un fichier php qui génère une partie de la structure XHTML d'une page. 

La vue à afficher dans la page index est définie par le paramètre "view" qui doit être placé dans la chaîne de requête. En fonction de la valeur de ce paramètre, on doit vérifier que l'on a suffisamment de données pour inclure le template nécessaire, puis on appelle le template à l'aide de la fonction include

Les formulaires de toutes les vues générées enverront leurs données vers la page data.php pour traitement. La page data.php redirigera alors vers la page index pour réafficher la vue pertinente, généralement la vue dans laquelle se trouvait le formulaire. 
*/


	// Dans tous les cas, on affiche l'entete, 
	// qui contient les balises de structure de la page, le logo, etc. 
	// Le formulaire de recherche ainsi que le lien de connexion 
	// si l'utilisateur n'est pas connecté 
	include("templates/header.php");

	
	

	if (isset($_GET["view"]))
		$view = $_GET["view"];
	else 
		$view = false;

	// S'il est vide, on charge la vue accueil par défaut
	if (!$view) $view = "accueil"; 

	// En fonction de la vue à afficher, on appelle tel ou tel template
	switch($view)
	{		

		case "accueil" : 
			include("templates\acceuil.php");
		break;

		case "connexion" :
			include("templates\connexion.php");
		break;

		case "Inscription" :
			include("templates\Inscription.php");
		break;

		case "Visualisation_de_seance" :
			include("templates\Visualisation_de_seance.php");
		break;

		case "gererEntrainement" :
			include("templates\gererEntrainement.php");
		break;

		case "statistiques" :
			include("templates\statistiques.php");
		break;

		case "CreerExercice" :
			include("templates/CreerExercice.php");
		break;

		case "GererGroupes" :
			include("templates/GererGroupes.php");
		break;

		case "voirseance" :
			include("templates/voirseance.php");
		break;




		default : // si le template correspondant à l'argument existe, on l'affiche
			if (file_exists("templates/$view.php"))
				include("templates/$view.php");

	}


	include ("templates/footer.php")

?>