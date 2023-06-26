<head>
    <Title> Circuit-Training </Title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script>

function changePage(url) {
    window.location.href = url;
}


    </script>
    <style>
#header {
    height: 5%;
    border-bottom: solid 1px black;
    height: fit-content
    display: flex;
    justify-content: center;
    align-items: center;
}

#header  h1,img{
    margin: 0%;

}
#logoUser{
    height:1.5em ;
    width: 1.5em;
   
    
}
    </style>
</head>
<div id="header">
    <h1 onclick="changePage('index.php?view=acceuil')">Circuit Training</h1>
    <img src="ressource\person_circle_icon_159926.png" id="logoUser" alt="Accéder a votre compte" onclick="changePage('index.php?view=connexion')">
</div>
<body>
    
