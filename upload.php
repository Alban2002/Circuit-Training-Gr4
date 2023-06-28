<?php
session_start();
include_once "libs/maLibSQL.pdo.php";

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Vérifie si le fichier image est une image réelle ou une image fausse
if(isset($_POST["action"])) {
  $ID_coach=$_SESSION["idUser"];
  $configurateur=$_POST["configurateur"];
  $nom=$_POST["nom"];
  $description=$_POST["description"];

  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Vérifie si le fichier existe déjà
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Vérifie la taille du fichier
if ($_FILES["fileToUpload"]["size"] > 50000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Autorise certains formats de fichiers
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Vérifie si $uploadOk est défini à 0 par une erreur
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// Si tout va bien, essayez d'uploader le fichier
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $SQL = "INSERT INTO exercices(nom,description,media,ID_coach,configurateur)";
    $SQL .= "VALUES ('$nom', '$description', '$target_file','$ID_coach','$configurateur')";
    $insert=SQLInsert($SQL);
    $reponse= "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    $qs="?view=CreerExercice&reponse=$reponse";
    
  } else {
    $reponse= "Sorry, there was an error uploading your file.";
  }
  $urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
  header("Location:" . $urlBase . $qs);
}
?>
