<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php"); ?>
<!DOCTYPE html>
<html>
<body>
<?php
$ID_Group = $_GET["reponse"];
afficherEleveGroupe($ID_Group);
?>

</body>
</html>
