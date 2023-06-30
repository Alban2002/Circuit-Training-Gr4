
<style>
    .selection1:hover,.selection2:hover {
    background: linear-gradient(white,black);
  }
  .contenairselect {
    width: 70%;
    display: flex;

}
#contenuNC {
  display: flex;
  flex-direction: column;
}
</style>
<div id="contenuNC">
<div class="contenairselect">
<div id="LieneConnexion" class="selection1" onclick="changePage('index.php?view=connexion')">
    <h2 class="titreselec">Se connecter</h2>
</div>
<div id="LienInscription" class="selection2" onclick="changePage('index.php?view=Inscription')">
    <h2 class="titreselec" >S'inscrire</h2>
</div>
</div>
<div id="présentation">
<h2>Qu'est-ce que Circuit-Training ?</h2>
<p> Application WEB permettant le suivi et la mesure d’entraînements de musculation déterminés et datés par des coachs professionels.</p>
</div>   
</div>

