<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php"); ?>
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
<form action="controleur.php" method="GET">
<select name="idUser">
<?php
$users = listerUtilisateurs();

// préférer un appel à mkSelect("idUser",$users, ...)
foreach ($users as $dataUser)
{
	echo "<option value=\"$dataUser[ID_user]\">";
    echo $dataUser["pseudo"]; 
    echo "</option>\n";
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
    echo "<option value=\"$dataGroup[ID_groupe]\">";
	echo  $dataGroup["description"];
	echo "</option>\n"; 
}
?>
</select>
</div>
<div>

<input type="submit" name="action" value="Associer" />
</form>
<h1>Créer un groupe</h1>
<div>
<form action="controleur.php" method="GET">
Description : <input type="text" name="description" value="" />
</div>
<input type="submit" name="action" value="Créer Groupe"/>
</form>

<h1>Modifier un groupe</h1>
<form action="controleur.php" method="GET">
<div class="container">
<h2>Groupe</h2>
<select name="idGroup2">
<?php
$group = listerGroup();

// préférer un appel à mkSelect("idUser",$users, ...)
foreach ($group as $dataGroup)
{
    echo "<option value=\"$dataGroup[ID_groupe]\">";
	echo  $dataGroup["ID_groupe"];
	echo "</option>\n"; 
}
?>
</select>
</div>
<div>

<input type="submit" name="action" value="Modifier Groupe" />
</form>


</body>
</html>
