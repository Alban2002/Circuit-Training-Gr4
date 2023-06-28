<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion entrainement</title>
    <script type="text/javascript" src="../libs/jquery-3.7.0.min.js"></script>
    <script type="text/javascript" src="../libs/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../libs/api-roots.js"></script>
    <link rel="stylesheet" href="../libs/jquery-ui/jquery-ui.css">

    <?php include_once 'fonctions_gererEntrainement.php'; ?>
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
        #contenu li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
        #contenu li span { position: absolute; margin-left: -1.3em; }
    </style>
</head>

<script>
    var exercises = [];
    var currentExerciseIndex = 0;
    var timer;
    var userId = 1;
    var seanceId = 123183;


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
    /*
        comportement au click
        nécessite de cloner avec .clone(true)
                .click(function(){
            $(this).html("touché !");
        });
    */

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
            url: "fonctions_gererEntrainement.php",
            data: { action: "fetchListeExercises",  userId: userId },
            dataType: "json",
            success: function(response) {
                console.log("success");
                exercises = response;
                var exerciseList = $('#contenu');
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
    }); // fin quand doc pret

    var jTa = $("<textarea class='tags'>")
        .keydown(function(contexte){
            // On vient d'appuyer sur une touche
            // alors qu'on était dans le ta.
            // laquelle ?

            //console.log(contexte.which);
            if (contexte.which == 13) {
                // appui sur entree
                // AVANT que ce saut de ligne ne soit inséré
                // dans le textarea
                // On supprime le textarea
                // On le remplace par un P.
                var content =  $(this).val();
                $(this).replaceWith(mkP(content));
            }
        });

    function mkTextarea(contenu) {
        // recup contenu P.
        // => refJP.html()
        // créer un textarea avec le mm contenu
        // Et un comportement sur keyDown sur ENTREE

        // ON AJOUTE UNE META-DONNEE au textarea
        // correspondant à la valeur actuelle du P.
        var jCTa = jTa.clone(true);
        jCTa
            .val(contenu)
            .data("contenuInitial",contenu);
        return jCTa;
    }

    function mkP(contenu) {
        // recup contenu TA.
        // => refJTA.val()
        // créer un P avec le mm contenu
        var jCP = jP.clone();
        jCP.html(contenu);
        return jCP;
    }

    /*
    <textarea>
    ce contenu : .val()
    </textarea>
    */


</script>

<body>
<h1>Créateur d'exercice</h1>
<h2>Ajouter un exercice</h2>

<ul id="contenu">

</ul>

</body>



