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
            margin-top: 60px;
            display : flex;
            justify-content: center;
        }
        h2 {
            display : flex;
            justify-content: center;
        }
        
        form {
            margin-bottom: 20px;
            display : flex;
            justify-content: center;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
        }
        
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
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
        display : flex;
        justify-content: center;
        }
        .button_activeable{
        display : flex;
        justify-content: center;
        margin-top:20px;
        }
        .button_retour{
        display : flex;
        justify-content: center;
        margin-top:50px;
        cursor: pointer;
        }
        .fin{
            margin-bottom:50px;
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
foreach ($users as $dataUser)
{
	echo "<option value=\"$dataUser[ID_user]\">";
    echo $dataUser["pseudo"]; 
    echo "</option>\n";
}
?>
</select>
</div>
<h2>Groupe</h2>
<div class="container">
<select name="idGroup">
<?php
$group = listerGroup();
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
<div class="button_activeable">
<input type="submit" name="action" value="Associer" />
</div>
</form>
<h1>Créer un groupe</h1>
<div>
<form action="controleur.php" method="GET">
Description : <input type="text" name="description" value="" />
</div>
<div class="button_activeable">
<input type="submit" name="action" value="Créer Groupe"/>
</div>
</form>

<h1>Modifier un groupe</h1>
<h2>Groupe</h2>
<div class="container">

<form action="controleur.php" method="GET">
<select name="idGroup2">
<?php
$group = listerGroup();

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
<div class="button_activeable">
<input type="submit" name="action" value="Modifier ce groupe" />
</div>
</form>

<div class="button_retour">
        <input type="button" value="Retour" onclick="changePage('index.php')">
</div>
<div class="fin">
</div>

</body>
</html>
