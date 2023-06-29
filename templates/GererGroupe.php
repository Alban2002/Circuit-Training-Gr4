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
            display : flex;
            justify-content : center;
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
        
        input[type="submit"], input[type="button"] {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;

        }
        
        .button-container {
            margin-top: 20px;
            display : flex;
            justify-content: center;
        }
        .fin{
            margin-bottom:40px;
        }
    </style>
</head>
<body>
    <h1>Gestion groupe</h1>
    <h2>Utilisateurs dans le groupe</h2>
    <?php
    $ID_Group = $_GET["reponse"];
    afficherEleveGroupe($ID_Group);
    ?>
    <form action="controleur.php" method="GET">
        <select name="idUser2">
            <?php
            $users = afficherElevePasGroupe($ID_Group);

            foreach ($users as $dataUser)
            {
                echo "<option value=\"$dataUser[ID_user]\">";
                echo $dataUser["pseudo"];
                echo "</option>\n";
            }
            ?>
        </select>
        <input type="hidden" name="idGroup2" value="<?php echo $ID_Group; ?>">
        <input type="submit" name="action" value="Associer à ce groupe" />
    </form>

    <form action="controleur.php" method="GET">
        <input type="hidden" name="idGroup3" value="<?php echo $ID_Group; ?>">
        <input type="submit" name="action" value="Supprimer ce groupe" />
    </form>

    <div class="button-container">
        <input type="button" value="Retour" onclick="changePage('index.php?view=GererGroupes')">
    </div>
</html>
