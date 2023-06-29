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
<div id="corps">
		<h1>Inscription</h1>
	<div id="formCreateUser">
		<form action="controleur.php" method="POST">
		    pseudo: <input type="text" name="pseudo" /><br />
		    passeword : <input type="password" name="password" /><br />
            role :<select name="role" > 
            <option value="coach">coach</option>
            <option value="athlète">athlète</option>
            </select>
		    <input type="submit" name="action" value="Inscription" />
		 </form>
         <?php if (isset($_GET["reponse"])){
		$reponse = $_GET["reponse"];
         echo $reponse; }?>
	</div>
</div>