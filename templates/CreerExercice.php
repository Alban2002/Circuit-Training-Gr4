<style>

.exercice {
  height: 20%;
  width: 100%;
  min-height: 200px;
  border: solid 1px black;
  display: flex;
  flex-direction: lign;
  align-items: center;
  justify-content: center;
}
.exercice p,img, {
  margin-right: 10%;
}
.exercice p{
  font-size: 1.2rem;
}

.exercice img{
  height:10%;
  width: 10%;
  min-width: 150px;
  min-height: 150px;

}

.Exercices{
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

</style>
<h2>Créer un exercice</h2>
<form action="upload.php" method="POST" enctype="multipart/form-data">
  Nom de l'exercice <input type="textaera" name="nom">
  Type d'exercice : <select name="configurateur" >
    <option value="duree">duree</option>
    <option value="quantite">quantite</option>
    </select>
    Description :<input type="textaera" name="description">
  Ajouter une image ou Gif:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload" name="action">
</form>
<?php if (isset($_GET["reponse"])){
		$reponse = $_GET["reponse"];
         echo $reponse; }?>
<H2>Mes exercices</H2>
<div id="Exercices">
<?php
include_once("libs/maLibSQL.pdo.php");
$id_coach=$_SESSION["idUser"];
$SQL="SELECT * FROM exercices WHERE ID_coach='$id_coach'";
$data=SQLSelect($SQL);
if(!($data)){
  echo "<h3>Vous n'avez pas créer d'exercice</h2>";
} else{
foreach ($data as $exercice ) {
$configurateur=$exercice["configurateur"];
$nom=$exercice["nom"];
$description=$exercice["description"];
$url=$exercice['media'];
echo " <fieldset class='exercice'> ";
echo "<legend>$nom</legend>";
echo "Description :<p>$description</p>";
echo "Type :<p>$configurateur</p>";
echo "<img src='{$url}'  />";
echo "</fieldset>";
}

}

?>
<H2>Les exercices des autres coach</H2>
<div class="Exercices">
<?php
$SQL2="SELECT * FROM exercices WHERE ID_coach!='$id_coach'";
$data2=SQLSelect($SQL2);
foreach ($data2 as $exercice ) {
$configurateur=$exercice["configurateur"];
$nom=$exercice["nom"];
$description=$exercice["description"];
$url=$exercice['media'];
echo " <fieldset class='exercice'> ";
echo "<legend>$nom</legend>";
echo "Description :<p>$description</p>";
echo "Type :<p>$configurateur</p>";
echo "<img src='{$url}'  />";
echo "</fieldset>";

}

?>

</div>