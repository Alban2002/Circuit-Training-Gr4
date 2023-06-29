<style>
    .Séances{
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
    }
.seance{
    display: flex;
  flex-direction: lign;
  }

</style>
<H2>Créer seance</H2>
<input type="button" onclick="changePage('index.php?view=gererEntrainement')" value="Créer séance">
<H2>Mes séances</H2>
<div id="Seances">
<?php
include_once("libs/maLibSQL.pdo.php");
$id_coach=$_SESSION["idUser"];
$SQL="SELECT * FROM seance WHERE ID_coach='$id_coach'";
$data=SQLSelect($SQL);
if(!($data)){
  echo "<h3>Vous n'avez pas créer de séance</h2>";
} else{
foreach ($data as $seance) {
$type=$seance["type"];
$nom=$seance["nom"];
$description=$seance["description"];
$duree=$seance['duree'];
$difficulte=$seance['difficulte'];
echo " <fieldset class='seance'> ";
echo "<legend>$nom</legend>";
echo "Description :<p>$description</p>";
echo "Type :<p>$type</p>";
echo "Durée :<p>$duree</p>";
echo "Difficultée :<p>$difficulte</p>";
echo "</fieldset>";
}

}
