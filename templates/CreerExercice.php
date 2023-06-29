<style>

.exercice {
  height: 20%;
  width: 100%;
  border: solid 1px black;
  display: flex;
  flex-direction: lign;
  align-items: center;
  justify-content: center;
}
.exercice p,img, {
  margin-right: 10%;
}

.exercice img{
  float: left;
  height:10%;
  width: 10%;
}

#Exercices{
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
foreach ( $data as $exercice ) {
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