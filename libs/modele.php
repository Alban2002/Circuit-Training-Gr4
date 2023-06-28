<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/


/********* EXERCICE 2 : prise en main de la base de données *********/


// inclure ici la librairie faciliant les requêtes SQL (en veillant à interdire les inclusions multiples)
include_once("maLibSQL.pdo.php");
include_once("config.php");
// fournit parcoursRS, SQLSelect, etc. 




function createNewUser($pseudo,$password,$role){
	global $BDD_host;
	global $BDD_base;
	global $BDD_user;
	global $BDD_password;
	
	$SQL = "SELECT * FROM users where pseudo='$pseudo'";
	$obj= SQLSelect($SQL); 
	if(!$obj){
		try {
		// Connexion à la base de données avec PDO
		$bdd = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Préparation de la requête SQL
		$sql = "INSERT INTO users(pseudo,password,role)";
		$sql .= "VALUES ('$pseudo', '$password', '$role')";
		$stmt = $bdd->prepare($sql);
		$stmt->execute();
		
			// Réponse de succès à renvoyer au client
		$response = "Inscription effectuée avec succès !";
		echo $response;
		return $response;
		} catch(PDOException $e) {
			// En cas d'erreur, renvoyer un message d'erreur au client
		$error = "Erreur lors de l'inscription' : " . $e->getMessage();
		return $error;
		}
	}
	else{return "Ce pseudo existe déjà";}


}

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

function listerUtilisateurs($pseudo="")
{
	$SQL = "SELECT * FROM users where role='coach'"; 
	if ($pseudo!="") $SQL .= " WHERE pseudo like '$pseudo%'";
	$SQL .= " ORDER BY pseudo ASC";
 
	return parcoursRs(SQLSelect($SQL)); 
}

function listergroup()
{
	$SQL= "SELECT * FROM groupes join users on ID_COACH=ID_USER where ID_COACH=ID_USER";
	return parcoursRs(SQLSelect($SQL));
}
function CreerGroupe($description)
{
	$SQL= "insert into groupes (ID_COACH, description) VALUES(ID_USER,$description)";
	return SQLInsert($SQL);
}
function VoirSesEleves()
{
	$SQL = "select * from attribution groupe join groupes on ID_groupe where ID_COACH=ID_USER";
	return parcoursRS($SQL);
}
function AjouterEleveGroupe($ID_Eleves, $ID_Groupe)
{
	$SQL = "insert into attribution groupe (ID_groupe, ID_athlete) VALUES($ID_Groupe,$ID_Eleves)";
	return SQLInsert($SQL);
}
function SupprimerEleveGroupe($ID_Eleves,$ID_Groupe)
{
	$SQL= "Delete from attribution groupe where ID_group,ID_athlete=$ID_Groupe,$ID_Athlete";
	return SQLDelete($SQL);
}
?>
