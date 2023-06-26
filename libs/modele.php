<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/


/********* EXERCICE 2 : prise en main de la base de données *********/


// inclure ici la librairie faciliant les requêtes SQL (en veillant à interdire les inclusions multiples)
include_once("maLibSQL.pdo.php");
// fournit parcoursRS, SQLSelect, etc. 






function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	// =================================================
	// EXERCICE 4
	// ==================================================
	$SQL = "SELECT ID_user FROM users WHERE pseudo='$login' AND password='$passe'";
	//die($SQL);
	return SQLGetChamp($SQL);

	// On utilise SQLGetCHamp
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

function getRole($id){
	$SQL = "SELECT role FROM users WHERE ID_user='$id'";
	return SQLGetChamp($SQL);
}

?>
