<?php


include_once("maLibSQL.pdo.php");
include_once("maLibForms.php");
include_once("config.php");



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
	$SQL = "SELECT * FROM users where role='athlete'"; 
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
	$SQL= "insert into groupes (ID_COACH, description) VALUES($_SESSION[idUser],'$description')";
	return SQLInsert($SQL);
}
function VoirSesEleves()
{
	$SQL = "select * from attribution_groupe join groupes on ID_groupe where ID_COACH=ID_USER";
	return parcoursRS($SQL);
}
function AjouterEleveGroupe($ID_Eleves, $ID_Groupe)
{	$SQLverif = "select * from attribution_groupe where ID_groupe=$ID_Groupe and ID_athlete=$ID_Eleves";
		if (SQLSelect($SQLverif)==false){
	$SQL = "insert into attribution_groupe (ID_groupe, ID_athlete) VALUES($ID_Groupe,$ID_Eleves)";
	return SQLInsert($SQL);}
}
function SupprimerEleveGroupe($ID_athlete,$ID_Groupe)
{	$SQLverif = "select * from attribution_groupe where ID_groupe=$ID_Groupe and ID_athlete=$ID_athlete";
	if (SQLSelect($SQLverif)!=false){
	$SQL= "Delete from attribution_groupe where ID_groupe=$ID_Groupe and ID_athlete=$ID_athlete";
	return SQLDelete($SQL);}
}
function afficherEleveGroupe($ID_Groupe)
{	$SQL= " Select pseudo from users join attribution_groupe on ID_user=ID_athlete where ID_groupe=$ID_Groupe";
	return ParcoursRS(SQLSelect($SQL));
}
function EleveDansGroupe($ID_Groupe)
{	$SQL= " Select pseudo,ID_athlete from users join attribution_groupe on ID_user=ID_athlete where ID_groupe=$ID_Groupe";
	return ParcoursRS(SQLSelect($SQL));
}
function afficherElevePasGroupe($ID_Groupe)
{	$SQL= " Select pseudo,ID_user from users where role='athlete' Except Select pseudo,ID_user from users join attribution_groupe on ID_user=ID_athlete where ID_groupe=$ID_Groupe ";
	return ParcoursRS(SQLSelect($SQL));
}
function SupprimerGroupe($ID_Groupe)
{
	$SQL= "Delete from groupes where ID_groupe=$ID_Groupe";
	return SQLDelete($SQL);
}
?>
