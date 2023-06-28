<?php
include_once("../libs/modele.php");
include_once("../libs/maLibUtils.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Assigner des utilisateurs à des groupes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        
        h1 {
            margin-bottom: 20px;
        }
        
        form {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
        }
        
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
        }
        
        .success {
            color: green;
        }
        
        .error {
            color: red;
        }
        .container {
        display: grid;
        gap: 20px;
        }
    </style>
</head>
<body>
    <h1>Assigner des utilisateurs à des groupes</h1>
    <h2>Utilisateur</h2>
    <div class="container">
<select name="idUser">
<?php
$users = listerUtilisateurs();

// préférer un appel à mkSelect("idUser",$users, ...)
$dernier = valider("dernier");
foreach ($users as $dataUser)
{
	if (($dernier != "") && ($dataUser['ID_user'] == $dernier))
	{
		echo "<option value=\"$dataUser[ID_user]\" selected>\n";
	}
	else {
		echo "<option value=\"$dataUser[ID_user]\">\n";
	}
	
	echo  $dataUser["pseudo"];
	echo "\n</option>\n"; 
}
?>
</select>
</div>
<div class="container">
<h2>Groupe</h2>
<select name="idGroup">
<?php
$group = listerGroup();

// préférer un appel à mkSelect("idUser",$users, ...)
foreach ($group as $dataGroup)
{
	echo  $dataGroup["ID"];
	echo "\n</option>\n"; 
}
?>
</select>
</div>
<div>
<form action="controleur.php" method="GET">
<input type="button" name="action" value="Associer" />
</form>
<h1>Créer un groupe</h1>
<div>
<form action="controleur.php" method="GET">
description : <input type="text" name="action" value="Description" />
</form>
<button type="button" onclick="CreerGroupe(description)">Créer un groupe</button>
</div>
<h1>Supprimer un utilisateur d'un groupe</h1>
</body>
</html>
