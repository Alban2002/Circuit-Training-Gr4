

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