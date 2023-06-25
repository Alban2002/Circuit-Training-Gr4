<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion entrainement</title>
    <script type="text/javascript" src="../libs/jquery-3.7.0.min.js"></script>
    <script type="text/javascript" src="../libs/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../libs/api-roots.js"></script>
    <link rel="stylesheet" href="../libs/jquery-ui/jquery-ui.css">
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


    // preparation paragraphe
    var jP = $("<li>")
        .html("Nouveau P");
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

            if ($("input[value='+']").index($(this)) == 0) {
                // en haut
                $("#contenu").prepend(jClone);
            } else {
                // en bas
                $("#contenu").append(jClone);
            }

        }); // fin click  btn +

    var divBtnPlus = $("<div>")
        .append(	$("<input type='text' />")
            .click(function(){
                $(this).select();
            }))
        .append(btnPlus);

    // quand doc pret
    $(document).ready(function(){
        // inserer btn + en haut / bas
        $("#contenu").before(divBtnPlus.clone(true));
        $("#contenu").after(divBtnPlus.clone(true));

        $("#contenu").sortable();

        // click sur un P de la page
        // qu'il existe ou pas encore
        $(document).on("click","#contenu p", function(){
            var content = $(this).html();
            $(this).replaceWith(mkTextarea(content));
        }); // fin click sur un P de la page

        // appui sur ESC dans la page
        $(document).on("keyup",function(contexte){
            //console.log(contexte.which);
            if (contexte.which == 27) {
                // on veut annuler TOUS LES TEXTAREA
                $("#contenu textarea").each(function(){
                    console.log("manipulation de " + $(this).val());
                    // Il nous faut une solution
                    // pour stocker le contenu initial
                    // de chaque paragraphe
                    // afin de pouvoir annuler l'édition
                    var lastContent = $(this).data("contenuInitial");
                    var content = $(this).val();
                    // on annule
                    $(this).replaceWith(mkP(lastContent));
                    // si on voulait valider
                    // $(this).replaceWith(mkP(content));
                });
            }
        });


        // Lors du survol d'un textarea
        // on affiche ses méta-données
        $(document).on("mouseover","textarea", function(){
            console.log($(this).data());
        });

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
    $( function() {
        var availableTags = [
            "ActionScript",
            "AppleScript",
            "Asp",
            "BASIC",
            "C",
            "C++",
            "Clojure",
            "COBOL",
            "ColdFusion",
            "Erlang",
            "Fortran",
            "Groovy",
            "Haskell",
            "Java",
            "JavaScript",
            "Lisp",
            "Perl",
            "PHP",
            "Python",
            "Ruby",
            "Scala",
            "Scheme"
        ];
        $( "#tags" ).autocomplete({
            source: availableTags
        });
    } );

</script>

<body>

<ul id="contenu">
    <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Premier P. </li>
    <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Second P. </li>

</ul>

</body>



