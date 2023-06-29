<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Chargement initial des groupes
            $.post('../libs/Fonctions_SceanceGroupe.php', { action: 'getGroupes' }, function(data) {
                $.each(data, function(key, value) {
                    $('#groupes').append('<option value="' + value.ID_groupe + '">' + value.description + '</option>');
                });
            }, 'json');

            // Événement de changement pour le groupe
            $('#groupes').change(function() {
                var groupeId = $(this).val();

                // Vide la liste des séances
                $('#seanceSupprimer').empty();

                // Chargement des séances pour le groupe sélectionné
                $.post('../libs/Fonctions_SceanceGroupe.php', { action: 'getGroupSeances', groupeId: groupeId }, function(data) {
                    $.each(data, function(key, value) {
                        $('#seanceSupprimer').append('<option value="' + value.ID_seance + '">' + value.nom + '</option>');
                    });
                }, 'json');
            });


            $.post('../libs/Fonctions_SceanceGroupe.php', { action: 'getSeances' }, function(data) {
                $.each(data, function(key, value) {
                    $('#seanceAjouter').append('<option value="' + value.ID_seance + '">' + value.nom + '</option>');
                });
            }, 'json');



            // Fonction pour supprimer la séance sélectionnée
            $('#btnSupprimer').click(function() {
                var seanceId = $('#seanceSupprimer').val();

                // Envoyer une requête AJAX pour supprimer la séance
                $.post('../libs/Fonctions_SceanceGroupe.php', { action: 'delete', seanceId: seanceId }, function(response) {
                    // Afficher le message de succès ou d'erreur
                    alert(response);
                    // Supprimer l'option de la séance dans la liste déroulante
                    $('#seanceSupprimer option:selected').remove();
                });
            });
        });
    </script>
</head>
<body>

<h2>Attribution de séances à un groupe</h2>

<form action="../libs/Fonctions_SceanceGroupe.php" method="post">
    <input type="hidden" name="action" value="insert">
    <label for="groupes">Choisir un groupe:</label><br>
    <select id="groupes" name="groupes">
        <option value="" disabled selected>Choisissez un groupe</option>
    </select><br>
    <label for="seanceAjouter">Choisir une séance:</label><br>
    <select id="seanceAjouter" name="seanceAjouter">
        <option value="" disabled selected>Choisissez une séance</option>
    </select><br>
    <label for="date">Choisir une date:</label><br>
    <input type="date" id="date" name="date" required><br>
    <input type="submit" value="Ajouter">
</form>


<h3>Supprimer une séance</h3>
<label for="seanceSupprimer">Sélectionner une séance:</label><br>
<select id="seanceSupprimer" name="seanceSupprimer">

</select><br>
<button id="btnSupprimer">Supprimer</button>

</body>
</html>
