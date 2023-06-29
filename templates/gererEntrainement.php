<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion entrainement</title>
    <script type="text/javascript" src="libs/jquery-3.7.0.min.js"></script>
    <script type="text/javascript" src="libs/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="libs/api-roots.js"></script>
    <link rel="stylesheet" href="libs/jquery-ui/jquery-ui.css">

    <?php include_once 'templates/fonctions_gererEntrainement.php'; ?>
    <style>
        #contenu {margin:5px 0px;}
        #contenu p:hover {
            cursor:pointer;
            border:1px dashed black;
        }
        #contenu textarea {
            display:block;
            width:100%;
            margin: 3px 0px;
        }
        #contenu { list-style-type: none; margin: 0; padding: 0; width: 60%; }
        #contenu li { margin: 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
        #contenu li span { position: absolute; margin-left: -1.3em; }
        #contenu li input { width: 50px }
        #contenu li label { margin-left: 20px; font-size: small }

        #seance_form {
            display: inline;
        }

        #createurSeance{
            display: none;
        }
    </style>
</head>

<script>
    var exercises = [];
    var userId = 1;
    var seanceId = 123183;

    function getSeanceValues() {
        var values = [];


        values.push({
            // Récupérer les valeurs des champs de saisie
            nom: $("#nom_seance").val(),
            description: $("#description_seance").val(),
            duree: $("#duree_seance").val(),
            // Récupérer la valeur du bouton radio sélectionné
            difficulte: $("input[name='difficulte']:checked").val(),
            // Récupérer la valeur de la séance sélectionnée dans la liste déroulante
            type_seance: $("#type_seance").val()
        });




        $('#seance_form').hide();
        $('#createurSeance').show();
        $('h2').eq(0).html("Séance : " + values.nom);
        return values;
    }

    function findExerciseByName(exerciseName) {
        for (var i = 0; i < exercises.length; i++) {
            if (exercises[i].nom === exerciseName) {
                return exercises[i];
            }
        }
        return null; // Exercise not found
    }

    // preparation paragraphe
    var jP = $("<li>")
        .html("Nouveau P")
        .addClass("ui-state-default");


    // preparation btn +
    var btnPlus = $("<input type='button' />")
        .val("+")
        .click(function(){
            // click sur btn +
            // => $(this) dénote le btn + cliqué
            console.log($(this).prev().val());
            var selectedExercise = findExerciseByName($(this).prev().val());
            console.log(selectedExercise);
            console.log("click +");

            var jClone = jP.clone();
            // lire le contenu du champ input
            // situé avant le btn cliqué
            // refJQSurElt1.prev()
            // renvoie une ref jQ sur l'élt situé juste avant Elt1
            // dans le DOM
            var lbl = $(this).prev().val();

            if (lbl != "") {
                // si contenu champ qui précède btn n'est pas vide
                // On s'en sert pour donner une valeur au P inséré
                jClone.html('<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'+lbl);
            }

            if (selectedExercise != null) {
                // Add exercise data as a data attribute
                jClone.data('ID_exo', selectedExercise.ID_exo);
                jClone.data('configurateur',selectedExercise.configurateur);
                console.log("jClone");
                console.log(jClone.data());

                // Create input field
                var inputField = $('<input>').attr('type', 'text');

                // Determine the label based on the configurateur
                var configurateurLabel = '';
                if (selectedExercise.configurateur === 'duree') {
                    configurateurLabel = 'Durée (s):';
                } else if (selectedExercise.configurateur === 'quantite') {
                    configurateurLabel = 'Quantité:';
                }

                // Create label element
                var label = $('<label>').text(configurateurLabel);

                // Add label and input field to jClone
                jClone.append(label, inputField);

                if ($("input[value='+']").index($(this)) == 0) {
                    // en haut
                    $("#contenu").prepend(jClone);
                } else {
                    // en bas
                    $("#contenu").append(jClone);
                }
            }

        }); // fin click  btn +

    var divBtnPlus = $("<div>")
        .append(	$("<input class='champTexte' type='text' />")
            .click(function(){
                $(this).select();
            }))
        .append(btnPlus);

    // quand doc pret
    $(document).ready(function(){

        // inserer l'ajout d'exercice
        $("#contenu").before(divBtnPlus.clone(true));
        $("#contenu").before('<h3>Séance en construction</h3>');

        //Requête AJAX pour récupérer les exercices
        console.log("ajax");
        $.ajax({
            type: "POST",
            url: "templates/fonctions_gererEntrainement.php",
            data: { action: "fetchListeExercises",  userId: userId },
            dataType: "json",
            success: function(response) {
                console.log("success");
                exercises = response;
                var availableTags = [];

                $.each(exercises, function(index, item) {
                    //Récupérer les noms des exercices pour créer l'autocomplétion
                    availableTags.push(item.nom);
                });

                $(".champTexte").autocomplete({
                    source: availableTags,
                    select: function(event, ui) {
                        var selectedExercise = findExerciseByName(ui.item.value);
                        console.log(selectedExercise);
                    }
                });
            }
        });
        $("#contenu").sortable(); //Permettre le réarrangement des exercices

        var seanceValues;
        //Soumettre le formulaire de création de séance avant de construire la séance
        $("#seance_form").submit(function(event) {
            event.preventDefault();

            // Appeler la fonction getSeanceValues pour obtenir les valeurs saisies
            seanceValues = getSeanceValues();

            // Faire quelque chose avec les valeurs récupérées
            console.log(seanceValues);

            // Réinitialiser le formulaire
            //$("#seance_form")[0].reset();
        });

        var listeExercices = []; // Variable pour stocker les exercices de la séance

        // Gestionnaire de clic sur le bouton "Enregistrer la séance"
        $('#enregistrer_seance').click(function() {
            // Réinitialiser la variable de séance
            listeExercices = [];

            // Parcourir la liste des exercices dans #contenu
            $('#contenu li').each(function() {
                var exerciseData = $(this).data('ID_exo'); // Récupérer les données de l'exercice
                var exerciseIndex = $(this).index()+1; // Récupérer l'index de l'exercice dans la liste
                var exerciseConfig = $(this).data('configurateur'); // Récupérer le configurateur de l'exercice dans la liste

                // Ajouter l'exercice et son index à la variable de séance
                listeExercices.push({
                    exercice: exerciseData,
                    index: exerciseIndex,
                    configurateur: exerciseConfig,
                    valeur : $(this).find('input').val()
                });
            });

            console.log(listeExercices); // Afficher la variable de listeExercices dans la console
            $.ajax({
                type: 'POST',
                url: 'templates/fonctions_gererEntrainement.php',
                data: {
                    action: 'enregistrerSeance',
                    userId: userId,
                    ListeExercices: listeExercices,
                    seance: seanceValues },
                dataType: 'json',
                success: function(response) {
                    console.log('Séance enregistrée avec succès');
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error('Erreur lors de l\'enregistrement de la séance:', error);
                }
            });
        });

        // Gestionnaire de clic sur le bouton "Quitter"
        $('#quitter').click(function() {
            // Vider la liste des exercices dans #contenu
            $('#contenu').empty();

            // Masquer le créateur de séance et afficher le formulaire
            $('#createurSeance').hide();
            $('#seance_form').show();
        });
    }); // fin quand doc pret

</script>

<body>
<h1>Créateur de séance</h1>

<h2>Votre séance</h2>
<form id="seance_form">
    <p>Nom de la séance :</p>
    <input id="nom_seance" type="text" /><br>
    <p>Description de la séance :</p>
    <input id="description_seance" type="text" /><br>
    <p>Durée estimée de la séance :</p>
    <input id="duree_seance" type="text" /><br>
    <p>Difficulté :</p>
    <label><input type="radio" name="difficulte" value="facile">Facile</label>
    <label><input type="radio" name="difficulte" value="intermediaire">Intermédiaire</label>
    <label><input type="radio" name="difficulte" value="confirme">Confirmé</label><br>
    <p>Type de séance :</p>
    <select id="type_seance">
        <option value="cardio">Cardio</option>
        <option value="renforcement">Renforcement</option>
        <option value="endurance">Endurance</option>
    </select><br>
    <br>
    <input type="submit" value="Créer séance" />
</form>

<div id="createurSeance">
    <input id="enregistrer_seance" type="button" value="enregistrer la séance"/>
    <input id="quitter" type="button" value="quitter"/>
    <h2>Ajouter un exercice</h2>

    <ul id="contenu">

    </ul>
</div>

</body>



