<?php 
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=connexion");
	die("");
}
?>
<style>
#corps input{
	min-width: 100px;
	min-height: 40px;
	padding: auto;
}

#corps {
	display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
</style>
<?php
if (isset($_SESSION["connecte"]))
$connecte=$_SESSION["connecte"];
else 
$connecte=false;

	if(!$connecte){
		echo'<div id="corps">';
		echo '<h1>Connexion</h1>';
		echo '<div id="formLogin">';
		echo '<form action="controleur.php" method="GET">';
		echo 'Login : <input type="text" name="login" /><br />';
		echo 'Passe : <input type="password" name="passe" /><br />';
		echo '<input type="submit" name="action" value="Connexion" />';
		echo '</form>';
		echo '</div>';
		echo "<a href='index.php?view=Inscription'>S'inscrire</a>";
		echo '</div>';
	}
	else {
		echo'<div id="corps">';
		echo '<h1>Deconnexion</h1>';
		echo '<div id="formLogout">';
		echo '<form action="controleur.php" method="GET">';
		echo '<input type="submit" name="action" value="deconnexion"/>';
		echo '</form>';
		echo '</div>';
		echo '</div>';
		}
	

?>



