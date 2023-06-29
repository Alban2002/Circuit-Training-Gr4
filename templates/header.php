<head>
    <Title> Circuit-Training </Title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script>

function changePage(url) {
    window.location.href = url;
}

function reponseInsc($reponse){
    $("#formCreateUser").after($reponse);

}

    </script>
   
</head>
<header id="header">
    <h1 onclick="changePage('index.php?view=acceuil')">Circuit Training</h1>
    <img src="ressource\person_circle_icon_159926.png" id="logoUser" alt="Accéder a votre compte" onclick="changePage('index.php?view=connexion')">
</header>
<div id="contenu">

    
