<html>
<head>
    <title>Bienvenue athlète!</title>

    <style>
        h1 {
            text-align: center;
        }

        .boutons-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .selection1,
        .selection2 {
            padding: 20px;
            border-radius: 5px;
        }
        .selection1:hover,.selection2:hover {
    background: linear-gradient(white,black);
  }
    </style>

</head>
<body>
    <h1>Bienvenue <?php echo $_SESSION['pseudo']; ?>!</h1>

    <div class="boutons-container">
        <div id="Lienentrainements" class="selection1" onclick="changePage('index.php?view=Visualisation_de_seance')">
            <h2 class="titreselec">Accéder à mes entrainements</h2>
        </div>
        <div id="Lienstats" class="selection2" onclick="changePage('index.php?view=statistiques')">
            <h2 class="titreselec">Accéder à mes statistiques</h2>
        </div>
    </div>
</body>

</html>
