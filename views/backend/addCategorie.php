<?php 
ob_start();
?>
<h2 class="text-center">Formulaire de création d'une catégorie</h2>
<br>
<form method="POST">
  <div class="form-group text-center col-6 offset-3">
    <label for="categorie">Veuillez entrer le nom de la catégorie à créer :</label>
    <input type="text" class="form-control text-center" id="categorie" name='categorie' placeholder="Nom de la catégorie" >
    
  </div>
  <div class='text-center'>
  <button type="submit" class="btn btn-primary" name="add"><i class='fas fa-plus'></i>Créer</button>
  </div>
</form>
<?php
$contenu = ob_get_clean();
require_once('template.php');
?>