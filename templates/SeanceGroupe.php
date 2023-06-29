<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            function loadGroupSeances(groupeId) {
                // Vide la liste des séances
                $('#seanceSupprimer').empty();

                // Chargement des séances pour le groupe sélectionné
                $.post('../libs/Fonctions_SceanceGroupe.php', { action: 'getGroupSeances', groupeId: groupeId }, function(data) {
                    $.each(data, function(key, value) {
                        $('#seanceSupprimer').append('<option value="' + value.ID_attribution_seance + '">' + value.nom + ' ' + value.date + '</option>');
                    });
                }, 'json');
            }
            // Chargement initial des groupes
            $.post('../libs/Fonctions_SceanceGroupe.php', { action: 'getGroupes' }, function(data) {
                $.each(data, function(key, value) {
                    $('#groupes').append('<option value="' + value.ID_groupe + '">' + value.description + '</option>');
                });
            }, 'json');

            // Événement de changement pour le groupe
            $('#groupes').change(function() {
                var groupeId = $(this).val();
                loadGroupSeances(groupeId);
            });



            $.post('../libs/Fonctions_SceanceGroupe.php', { action: 'getSeances' }, function(data) {
                $.each(data, function(key, value) {
                    $('#seanceAjouter').append('<option value="' + value.ID_seance + '">' + value.nom + '</option>');
                });
            }, 'json');



            // Fonction pour supprimer la séance sélectionnée
            $('#btnSupprimer').click(function() {
                var attributionId = $('#seanceSupprimer').val(); // Obtenez l'ID d'attribution de la séance à supprimer


                if (attributionId){
                    // Envoyer une requête AJAX pour supprimer la séance
                    $.post('../libs/Fonctions_SceanceGroupe.php', { action: 'deleteAttribution', attributionId: attributionId }, function(response) {
                        // Vérifiez si la suppression a réussi
                        if(response.status == 'success'){
                            // Afficher le message de succès
                            alert('Séance supprimée avec succès');
                            // Supprimer l'option de la séance dans la liste déroulante
                            $('#seanceSupprimer option:selected').remove();

                        } else {
                            // Afficher le message d'erreur
                            alert('La suppression a échoué: ' + response.message);
                        }
                    }, 'json');
                } else {
                    alert('Veuillez choisir une séance à supprimer..');
                }
            });






            // Fonction pour ajouter la séance sélectionnée
            $('#submit').click(function() {
                var seanceId = $('#seanceAjouter').val();
                var groupId = $('#groupes').val();
                var date = $('#date').val();
                if (seanceId && groupId && date){
                    // Envoyer une requête AJAX pour ajouter la séance
                    $.post('../libs/Fonctions_SceanceGroupe.php', { action: 'insertAttribution', groupes: groupId, seance: seanceId, date: date }, function(response) {
                        // Afficher le message de succès ou d'erreur
                        alert('Séance ajoutée');
                        // Recharger les séances du groupe
                        loadGroupSeances(groupId);
                    });
                } else {
                    alert('Veuillez remplir tous les champs avant de commencer.');
                }
            });




        });

    </script>
</head>
<body>

<h2>Attribution de séances à un groupe</h2>



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
    <button id="submit"> Ajouter</button>



<h3>Supprimer une séance</h3>
<label for="seanceSupprimer">Sélectionner une séance:</label><br>
<select id="seanceSupprimer" name="seanceSupprimer">
    <option value="" disabled selected>Choisissez une séance</option>

</select><br>
<button id="btnSupprimer">Supprimer</button>

</body>
</html>
