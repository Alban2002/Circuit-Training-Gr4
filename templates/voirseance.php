<script type="text/javascript" src="libs/jquery-3.7.0.min.js"></script>
<script type="text/javascript" src="libs/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="libs/api-roots.js"></script>
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
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .seance-container {
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 75%;
    }
    .seance p {
        margin-bottom: 0px; /* Ajuster la marge inférieure pour réduire l'espace entre les <p> */
        margin-top: 0px;
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
            $seanceId = $seance['ID_seance'];

            echo "<div class='seance-container'>";
            echo "<fieldset class='seance'>";
            echo "<legend>$nom</legend>";
            echo "<p>Description : $description</p>";
            echo "<p>Type : $type</p>";
            echo "<p>Durée : $duree</p>";
            echo "<p>Difficultée : $difficulte</p>";
            echo "</fieldset>";
            echo "<button onclick='deleteSeance($seanceId)'>Supprimer la séance</button>";
            echo "</div>";
        }
    }
    ?>
    <script>
        function deleteSeance(id_seance) {
            // Envoyer une requête AJAX pour supprimer la séance avec l'ID spécifié
            $.ajax({
                type: 'POST',
                url: 'templates/fonctions_gererEntrainement.php',
                data: {
                    action: 'supprimerSeance',
                    id_seance: id_seance
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Séance supprimée avec succès');
                    // Recharger la page pour mettre à jour la liste des séances
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Erreur lors de la suppression de la séance:', error);
                }
            });
        }
    </script>
</div>
