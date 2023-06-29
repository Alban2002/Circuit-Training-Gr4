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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/fr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <?php include_once 'libs/fonctions_Visualisation_de_seance.php'; ?>
    <meta charset="UTF-8">
</head>
<body>

<button id="startSeance" data-seance-id="123183">Commencer la séance</button>
<button id="repeatSeance" data-seance-id="123183" style="display: none;">Répéter la séance</button>
<button id="stopSeance" style="display: none;">Arrêter la séance</button>
<div id="exerciseContainer"></div>
<style>
    #startSeance{
        display: inline-block;
        padding: 10px 20px;
        margin: 10px 0;
        color: #fff;
        background-color: Green;
        border: none;
        border-radius: 5px;
        text-decoration: none;


    }
#stopSeance{
    display: inline-block;
    padding: 10px 20px;
    margin: 10px 0;
    color: #fff;
    background-color: #dc3545;
    border: none;
    border-radius: 5px;
    text-decoration: none;


}



    #repeatSeance{
        display: inline-block;
        padding: 10px 20px;
        margin: 10px 0;
        color: #fff;
        background-color: Green;
        border: none;
        border-radius: 5px;
        text-decoration: none;


    }
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
    .fc-event.selected {

        
        background-color: #ffc107 !important;  /* Couleur de fond pour la séance sélectionnée */

        border-color: #000000 !important;      /* Couleur de bordure pour la séance sélectionnée */
        color: #fff;                /* Couleur du texte pour la séance sélectionnée */
    }


    #seanceDetails {
        position: fixed;
        z-index: 999;
        top: 50px;  /* Adjust this to set the distance from the top */
        right: 20px;  /* Adjust this to set the distance from the right */
        width: 300px;  /* Width of the box */
        height: auto;  /* Height will adjust based on content */
        padding: 20px;  /* Padding around content */
        background: rgba(0,0,0,0.5);  /* Semi-opaque background */
        color: white;  /* Text color */
        border-radius: 10px;  /* Rounded corners */
    }

    #descriptionContainer {
        position: fixed;
        z-index: 999;
        top: 120px;  /* Adjust this to set the distance from the top */
        right: 20px;  /* Adjust this to set the distance from the right */
        width: 300px;  /* Width of the box */
        height: auto;  /* Height will adjust based on content */
        padding: 20px;  /* Padding around content */
        background: rgba(0,0,0,0.5);  /* Semi-opaque background */
        color: white;  /* Text color */
        border-radius: 10px;  /* Rounded corners */
    }



    #calendar {
         /* Utilise le positionnement absolu par rapport à l'élément parent */
        top: 50px; /* Déplace l'élément en haut de la page */
        left: 0; /* Déplace l'élément à gauche de la page */
        width: 60%; /* Définit la largeur de l'élément en pourcentage de la largeur de l'écran */
        height: auto; /* La hauteur de l'élément s'adapte au contenu */
        background-color: white; /* Couleur de fond de l'élément */
        padding: 10px; /* Ajoute un espace entre le contenu et les bords de l'élément */
        z-index: 2; /* Assure que l'élément s'affiche par-dessus les autres éléments */
        border: 1px solid lightgrey; /* Ajoute une bordure autour de l'élément */
    }

    .exercise-info {
        border: 1px solid #ccc;
        padding: 20px;
        margin-bottom: 20px;
    }

    .exercise-title {
        font-size: 1.5em;
        color: #333;
    }

    .exercise-image {

        height: 500px;
    }

    .exercise-duration, .exercise-quantity {
        font-size: 1.2em;
        color: #666;
    }

    /* bouton pou afficher description exo*/
    .btn {
        display: inline-block;
        padding: 10px 20px;
        margin: 10px 0;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        text-decoration: none;
    }

    .btn-skip {
        background-color: orange;
        margin: 10px;
    }
    .custom-event.to-do {
        background-color: lightblue;
        border-color: #E3F8FF;
    }
    .custom-event.missed {
        background-color: orangered;
        border-color: #FECFC5;
    }
    .custom-event.done {
        background-color: #B9F5BF;
        border-color: #E3FFE6;
    }
    .fc-title {
        color: #2C2C2C;

    }

    #feedbackModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .modal-content {

       color: #e5e5e5;
        padding: 20px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    #submitFeedback{
        display: inline-block;
        padding: 10px 20px;
        margin: 10px 0;
        color: #fff;
        background-color: Green;
        border: none;
        border-radius: 5px;
        text-decoration: none;



    }

</style>
<script>


    var selectedSeanceId;
    var ThisSelectedSeanceId;
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

            // Si l'utilisateur clique en dehors de #descriptionContainer, alors on le cache
            if ($(e.target).closest("#descriptionContainer").length === 0 && !$(e.target).is('#toggleDescription')) {
                $("#descriptionContainer").hide();
            }
        });

        function formatEvents(seances) {
            return seances.map(function(seance) {
                var eventDate = moment(seance.date, 'YYYY-MM-DD').toDate();
                let className;
                switch (seance.statut_seance) {
                    case 'a faire':
                        className = 'custom-event to-do';
                        break;
                    case 'non fait':
                        className = 'custom-event missed';
                        break;
                    case 'fait':
                        className = 'custom-event done';
                        break;
                    default:
                        className = 'custom-event';
                        break;
                }
                return {
                    title: seance.nom,
                    start: eventDate,
                    id: seance.ID_seance,
                    className: className,
                    statut_seance: seance.statut_seance, // Ajout de cette ligne qui créé un calEvent
                    idSelected: seance.ID_attribution_seance
                };
            });
        }











        $.ajax({
            type: "POST",
            url: "libs/fonctions_Visualisation_de_seance.php",
            data: { action: "fetchUserSeances", userId: userId },
            dataType: "json",
            success: function(response) {
                $('#calendar').fullCalendar({
                    locale: 'fr', //patch fr
                    displayEventTime: false, //patche heur
                    events: formatEvents(response),
                    eventClick: function(calEvent, jsEvent, view) {
                        // Vérifier si l'élément est déjà sélectionné
                        if ($(this).hasClass('selected')) {
                            // Désélectionner l'élément
                            $(this).removeClass('selected');
                            // Réinitialiser l'ID de la séance sélectionnée
                            selectedSeanceId = null;
                            ThisSelectedSeanceId = null;
                            // Cacher le menu déroulant
                            $('#seanceDetails').hide();
                        } else {
                            // Désélectionner toutes les autres séances
                            $('.fc-event').removeClass('selected');
                            // Sélectionner l'élément actuellement cliqué
                            $(this).addClass('selected');
                            // Récupérer l'ID de la séance sélectionnée
                            selectedSeanceId = calEvent.id;
                            ThisSelectedSeanceId = calEvent.idSelected;

                            // Faire une requête AJAX pour obtenir les détails de la séance
                            $.ajax({
                                type: "POST",
                                url: "libs/fonctions_Visualisation_de_seance.php",
                                data: { action: "fetchSeanceDetails", seanceId: selectedSeanceId },
                                dataType: "json",
                                success: function(response) {
                                    // Mettre à jour les détails de la séance dans le menu déroulant
                                    var seance = response[0];
                                    $('#seanceDescription').text('Description: ' + seance.description);
                                    $('#seanceDifficulte').text('Difficulté: ' + seance.difficulte);
                                    $('#seanceDuree').text('Durée: ' + seance.duree + ' minutes');
                                    $('#seanceType').text('Type: ' + seance.type);
                                    $('#seanceStatut').text('Statut de la séance: ' + calEvent.statut_seance); // Utilisation de calEvent.statut_seance ici

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
                    url: "libs/fonctions_Visualisation_de_seance.php",
                    data: { action: "fetchExercises",  seanceId: selectedSeanceId },
                    dataType: "json",
                    success: function(response) {
                        exercises = response;
                        displayExercise(currentExerciseIndex);
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "../libs/fonctions_Visualisation_de_seance.php",
                    data: {
                        action: "updateSeanceStatus",
                        seanceId: ThisSelectedSeanceId,
                        status: 'fait'


                    },



                    success: function() {
                        $.ajax({
                            type: "POST",
                            url: "libs/fonctions_Visualisation_de_seance.php",
                            data: { action: "fetchUserSeances", userId: userId },
                            dataType: "json",
                            success: function(response) {
                                $('#calendar').fullCalendar('removeEvents');
                                $('#calendar').fullCalendar('addEventSource', formatEvents(response));
                                $('#calendar').fullCalendar('rerenderEvents');
                            }
                        });
                    },
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
            // Créer et afficher une fenêtre modale pour recueillir les commentaires
            var feedbackModal = '<div id="feedbackModal" >' +
                '<div class="modal-content" >' +
                '<h4>Pour 1 étant très facile et 5 étant très compliqués, comment avez-vous trouvé cette séance ?</h4>' +
                '<p>' +
                '<input type="radio" name="rating" value="1"> 1 ' +
                '<input type="radio" name="rating" value="2"> 2 ' +
                '<input type="radio" name="rating" value="3"> 3 ' +
                '<input type="radio" name="rating" value="4"> 4 ' +
                '<input type="radio" name="rating" value="5"> 5 ' +
                '</p>' +
                '<button id="submitFeedback">Soumettre</button>' +
                '</div>' +
                '</div>';
            $('body').append(feedbackModal);

            $('#feedbackModal').show();

            $('#submitFeedback').click(function() {
                var rating = $('input[name="rating"]:checked').val();
                if (rating) {
                    $.ajax({
                        url: 'libs/fonctions_Visualisation_de_seance.php',
                        type: 'POST',
                        data: {
                            action: 'saveFeedback',
                            seanceId: ThisSelectedSeanceId,
                            rating: rating
                        },
                        success: function() {
                            $('#feedbackModal').remove();

                            // Cache le bouton "Arrêter la séance"
                            $('#stopSeance').hide();
                            // Montre le bouton "Commencer la séance"
                            $('#startSeance').show();
                            // Vide le conteneur d'exercices
                            $('#exerciseContainer').empty();
                            // Réinitialise l'index de l'exercice courant
                            currentExerciseIndex = 0;
                            selectedSeanceId = 0;
                            ThisSelectedSeanceId = 0;
                            // Arrête le timer en cours, s'il y en a un
                            if (timer) {
                                clearInterval(timer);
                            }
                            $('#repeatSeance').hide();
                            $("#calendar").show();
                        },
                        error: function() {
                            alert('Une erreur est survenue lors de la sauvegarde des commentaires');
                        }
                    });
                } else {
                    alert('Veuillez sélectionner une note');
                }
            });
        });



        function displayExercise(index) {
            var exercise = exercises[index];
            var exerciseHtml = `
        <div class="exercise-info">
            <h2 class="exercise-title">${exercise.nom}</h2>
            <img class="exercise-image" src="${exercise.media}" alt="${exercise.nom}">
        </div>
    `;

            if (exercise.duree > 0) {
                exerciseHtml += `<p class="exercise-duration">Durée : <span id="timer">${exercise.duree}</span> secondes</p>`;
                startTimer(exercise.duree);
            } else {
                exerciseHtml += `<p class="exercise-quantity">Quantité : ${exercise.quantite}</p>`;
            }

            // Ajout du bouton pour afficher la description de l'exercice
            exerciseHtml += `<button id="toggleDescription" class="btn">Description de l'exercice</button>`;

            // Ajout du bouton pour passer à l'exercice suivant
            exerciseHtml += `<button id="skipExercise" class="btn btn-skip">Passer</button>`; // Bouton pour passer l'exercice

            $('#exerciseContainer').html(exerciseHtml);

            // Ajout d'un écouteur d'événement pour le bouton "Description de l'exercice"
            $('#toggleDescription').on('click', function() {
                // Si le conteneur de la description est actuellement caché, afficher la description. Sinon, le cacher.
                if ($('#descriptionContainer').is(':hidden')) {
                    $('#descriptionContainer').html(`<h2 class="exercise-description">${exercise.description}</h2>`).show();
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
    /*
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
        */
    });

</script>
<div id="calendar"></div>
<div id="seanceDetails" style="display: none;">
    <h3>Détails de la séance</h3>
    <p id="seanceDescription"></p>
    <p id="seanceDifficulte"></p>
    <p id="seanceDuree"></p>
    <p id="seanceType"></p>
    <p id="seanceStatut"></p>
</div>

<form id="feedbackForm" style="display: none;">
    <h2>Veuillez noter votre séance :</h2>
    <label><input type="radio" name="rating" value="1"> 1</label>
    <label><input type="radio" name="rating" value="2"> 2</label>
    <label><input type="radio" name="rating" value="3"> 3</label>
    <label><input type="radio" name="rating" value="4"> 4</label>
    <label><input type="radio" name="rating" value="5"> 5</label>
    <button type="submit">Submit</button>
</form>


<div id="descriptionContainer" style="display:none;"></div>


</body>
</html>