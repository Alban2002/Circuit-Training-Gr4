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
    <img src="ressource\person_circle_icon_159926.png" id="logoUser" title="compte" alt="Accéder a votre compte" onclick="changePage('index.php?view=connexion')">
    <?php 
    if (isset($_SESSION["connecte"]))
    $connecte=$_SESSION["connecte"];
    else 
    $connecte=false;

    if (!$connecte){
        echo "<a href='index.php?view=Connexion' id='lienCo' >Se connecter</a>";
    }else{
        echo "<a href='controleur.php?action=deconnexion' id='lienCo'>Se deconnecter</a>";
    }?>
</header>
<div id="contenuPage">

    
