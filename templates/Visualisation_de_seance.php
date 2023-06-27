<!DOCTYPE html>
<html>
<head>
    <title>séances</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />

    <!-- Inclure les fichiers JavaScript de FullCalendar et de ses dépendances -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <?php include_once '../libs/fonctions.php'; ?>
    <meta charset="UTF-8">
</head>
<body>

<button id="startSeance" data-seance-id="123183">Commencer la séance</button>
<button id="repeatSeance" data-seance-id="123183" style="display: none;">Répéter la séance</button>
<button id="stopSeance" style="display: none;">Arrêter la séance</button>
<div id="exerciseContainer"></div>
<style>

    .custom-radio {
        width: 20px;
        height: 20px;
        vertical-align: -5px;
    }
    .radio-label {
        display: inline-block;
        padding: 5px;
        border: 1px solid #000;
        border-radius: 5px;
        background-color: #f5f5f5;
        margin: 5px;
    }
    .custom-event.selected {
        background-color: #ffc107;  /* Couleur de fond pour la séance sélectionnée */
        border-color: #ffc107;      /* Couleur de bordure pour la séance sélectionnée */
        color: #fff;                /* Couleur du texte pour la séance sélectionnée */
    }

    /* CSS */
    #seanceDetails {
        position: fixed;
        z-index: 999;
        top: 20px;  /* Adjust this to set the distance from the top */
        right: 20px;  /* Adjust this to set the distance from the right */
        width: 300px;  /* Width of the box */
        height: auto;  /* Height will adjust based on content */
        padding: 20px;  /* Padding around content */
        background: rgba(0,0,0,0.5);  /* Semi-opaque background */
        color: white;  /* Text color */
        border-radius: 10px;  /* Rounded corners */
    }

    #calendar {
        position: absolute; /* Utilise le positionnement absolu par rapport à l'élément parent */
        top: 50px; /* Déplace l'élément en haut de la page */
        left: 0; /* Déplace l'élément à gauche de la page */
        width: 65%; /* Définit la largeur de l'élément en pourcentage de la largeur de l'écran */
        height: auto; /* La hauteur de l'élément s'adapte au contenu */
        background-color: white; /* Couleur de fond de l'élément */
        padding: 10px; /* Ajoute un espace entre le contenu et les bords de l'élément */
        z-index: 2; /* Assure que l'élément s'affiche par-dessus les autres éléments */
        border: 1px solid lightgrey; /* Ajoute une bordure autour de l'élément */
    }

</style>
<script>
    var selectedSeanceId;
    $(document).ready(function() {
        var exercises = [];
        var currentExerciseIndex = 0;
        var timer;
        var userId = 1;


        $(document).click(function(e) {
            // Si l'utilisateur clique en dehors de #seanceDetails, alors on le cache
            if ($(e.target).closest("#seanceDetails").length === 0) {
                $("#seanceDetails").hide();
            }
        });

        $.ajax({
            type: "POST",
            url: "../libs/fonctions.php",
            data: { action: "fetchUserSeances", userId: userId },
            dataType: "json",
            success: function(response) {
                $('#calendar').fullCalendar({
                    events: response.map(function(seance) {
                        var eventDate = moment(seance.date, 'YYYY-MM-DD').toDate();
                        return {
                            title: 'Séance ' ,
                            start: eventDate,
                            id: seance.ID_seance,
                            className: 'custom-event'
                        };
                    }),
                    eventClick: function(calEvent) {
                        // Vérifier si l'élément est déjà sélectionné
                        if ($(this).hasClass('selected')) {
                            // Désélectionner l'élément
                            $(this).removeClass('selected');
                            // Réinitialiser l'ID de la séance sélectionnée
                            selectedSeanceId = null;
                            // Cacher le menu déroulant
                            $('#seanceDetails').hide();
                        } else {
                            // Désélectionner toutes les autres séances
                            $('.custom-event').removeClass('selected');
                            // Sélectionner l'élément actuellement cliqué
                            $(this).addClass('selected');
                            // Récupérer l'ID de la séance sélectionnée
                            selectedSeanceId = calEvent.id;

                            // Faire une requête AJAX pour obtenir les détails de la séance
                            $.ajax({
                                type: "POST",
                                url: "../libs/fonctions.php",
                                data: { action: "fetchSeanceDetails", seanceId: selectedSeanceId },
                                dataType: "json",
                                success: function(response) {
                                    // Mettre à jour les détails de la séance dans le menu déroulant
                                    var seance = response[0];
                                    $('#seanceDescription').text('Description: ' + seance.description);
                                    $('#seanceDifficulte').text('Difficulté: ' + seance.difficulte);
                                    $('#seanceDuree').text('Durée: ' + seance.duree);
                                    $('#seanceType').text('Type: ' + seance.type);

                                    // Afficher le menu déroulant
                                    $('#seanceDetails').show();
                                }
                            });
                        }
                    }



                });
            }
        });

        $('#startSeance').click(function() {
            if (selectedSeanceId) {  // Utilisation de la variable déclarée en haut
                $(this).hide();
                $("#calendar").hide();
                $('#stopSeance').show();
                $.ajax({
                    type: "POST",
                    url: "../libs/fonctions.php",
                    data: { action: "fetchExercises",  seanceId: selectedSeanceId },
                    dataType: "json",
                    success: function(response) {
                        exercises = response;
                        displayExercise(currentExerciseIndex);
                    }
                });
            } else {
                alert('Veuillez choisir une séance avant de commencer.');
            }
        });


        $('#repeatSeance').click(function() {
            $(this).hide(); // cache le bouton "Répéter la séance"

            $('#startSeance').show(); // montre le bouton "Commencer la séance"
            currentExerciseIndex = 0; // réinitialise l'index de l'exercice
        });

        $('#stopSeance').click(function() {
            // Cache le bouton "Arrêter la séance"
            $(this).hide();
            // Montre le bouton "Commencer la séance"
            $('#startSeance').show();
            // Vide le conteneur d'exercices
            $('#exerciseContainer').empty();
            // Réinitialise l'index de l'exercice courant
            currentExerciseIndex = 0;
            // Arrête le timer en cours, s'il y en a un
            if (timer) {
                clearInterval(timer);
            }
            $('#repeatSeance').hide();
            $("#calendar").show();
        });

        function displayExercise(index) {
            var exercise = exercises[index];
            var exerciseHtml = `
        <h2>${exercise.nom}</h2>
        <img src="${exercise.media}" alt="${exercise.nom}">
    `;

            if (exercise.duree > 0) {
                exerciseHtml += `<p>Durée : <span id="timer">${exercise.duree}</span> secondes</p>`;
                startTimer(exercise.duree);
            } else {
                exerciseHtml += `<p>Quantité : ${exercise.quantite}</p>`;
            }

            // Ajout du bouton pour afficher la description de l'exercice
            exerciseHtml += `<button id="toggleDescription">Description de l'exercice</button>`;

            // Ajout du bouton pour passer à l'exercice suivant
            exerciseHtml += `<button id="skipExercise">Passer</button>`; // Bouton pour passer l'exercice

            $('#exerciseContainer').html(exerciseHtml);

            // Ajout d'un écouteur d'événement pour le bouton "Description de l'exercice"
            $('#toggleDescription').on('click', function() {
                // Si le conteneur de la description est actuellement caché, afficher la description. Sinon, le cacher.
                if ($('#descriptionContainer').is(':hidden')) {
                    $('#descriptionContainer').html(`<h2>${exercise.description}</h2>`).show();
                } else {
                    $('#descriptionContainer').hide();
                }
            });
        }





// Cliquez sur le bouton "Passer"
        $(document).on('click', '#skipExercise', function() {
            if (timer) {
                clearInterval(timer);
            }
            nextExercise();

        });

        function nextExercise() {
            currentExerciseIndex++;
            if (currentExerciseIndex < exercises.length) {
                displayExercise(currentExerciseIndex);
            } else {
                endOfSession();
            }
        }

        function endOfSession() {
            $('#exerciseContainer').html('<p>Fin de la séance!</p>');
            $('#repeatSeance').show(); // montre le bouton "Répéter la séance"
        }

        function startTimer(duration) {
            var remaining = duration;
            timer = setInterval(function() {
                remaining--;
                $('#timer').text(remaining);
                if (remaining <= 0) {
                    clearInterval(timer);
                    // Passez à l'exercice suivant
                    currentExerciseIndex++;
                    if (currentExerciseIndex < exercises.length) {
                        displayExercise(currentExerciseIndex);
                    } else {
                        $('#exerciseContainer').html('<p>Fin de la séance!</p>');
                        $('#repeatSeance').show(); // montre le bouton "Répéter la séance"
                    }
                }
            }, 1000);
        }

        // Cliquez sur le bouton "Suivant"
        $(document).on('click', '#nextExercise', function() {
            currentExerciseIndex++;
            if (currentExerciseIndex < exercises.length) {
                displayExercise(currentExerciseIndex);
            } else {
                $('#exerciseContainer').html('<p>Fin de la séance!</p>');
                $('#repeatSeance').show(); // montre le bouton "Répéter la séance"

            }
        });
    });
</script>
<div id="calendar"></div>
<div id="seanceDetails" style="display: none;">
    <h3>Détails de la séance</h3>
    <p id="seanceDescription"></p>
    <p id="seanceDifficulte"></p>
    <p id="seanceDuree"></p>
    <p id="seanceType"></p>
</div>

<div id="descriptionContainer" style="display:none;"></div>


</body>
</html>