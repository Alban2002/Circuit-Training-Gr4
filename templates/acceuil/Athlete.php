<body>
<div class="contenairselect">
<div id="Lienentrainements" class="selection1">
    <h2 class="titreselec">Accéeder à mes entrainements</h2>
</div>
<div id="Lienstats" class="selection2" ondblclick="changePage('index.php?view=statistiques')">
    <h2 class="titreselec">Accéder à mes statistiques</h2>
</div>
</div>
</body>


<html>
<head>
    <title>Bienvenue athlète!</title>
    <style>
        .button {
            display: inline block;
            width: 200px;
            padding: 10px;
            margin-bottom: 10px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
        }

        .button:hover {
            background-color: #2680D1;
        }
    </style>
</head>
<body>
    <h1>Bienvenue "insérer nom"</h1>

    <a class="button" href="page_seances_preues.php">Mes séances</a>
    <a class="button" href="statistiques.php">Mes statistiques</a>

    <?php
    foreach ($_SESSION as $key => $value) {
        echo "Clé : " . $key . ", Valeur : " . $value . "<br>";
    }
    ?>
    
</body>

</html>