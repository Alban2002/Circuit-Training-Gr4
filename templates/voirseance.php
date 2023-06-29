<style>
    .seances {
        display: flex;
        flex-direction: column;
        align-items: flex-start; /* Aligner les blocs d'exercices à gauche */
        justify-content: center;
    }

    .seance {
        display: flex;
        flex-direction: column; /* Empiler les éléments <p> les uns au-dessus des autres */
    }

    .seance-container {
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>
<h2>Vos séances</h2>
<input type="button" onclick="changePage('index.php?view=gererEntrainement')" value="Créer séance">
<h2>Mes séances</h2>
<div id="Seances" class="seances">
    <?php
    include_once("libs/maLibSQL.pdo.php");
    $id_coach = $_SESSION["idUser"];
    $SQL = "SELECT * FROM seance WHERE ID_coach='$id_coach'";
    $data = SQLSelect($SQL);
    if (!($data)) {
        echo "<h3>Vous n'avez pas créé de séance</h3>";
    } else {
        foreach ($data as $seance) {
            $type = $seance["type"];
            $nom = $seance["nom"];
            $description = $seance["description"];
            $duree = $seance['duree'];
            $difficulte = $seance['difficulte'];

            echo "<div class='seance-container'>";
            echo "<fieldset class='seance'>";
            echo "<legend>$nom</legend>";
            echo "<p>Description : $description</p>";
            echo "<p>Type : $type</p>";
            echo "<p>Durée : $duree</p>";
            echo "<p>Difficultée : $difficulte</p>";
            echo "</fieldset>";
            echo "</div>";
        }
    }
    ?>
</div>
