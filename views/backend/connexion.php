<?php
ob_start();
?>

<div class="col-6 offset-3">
<div class="card ">
  <ul class="list-group list-group-flush">
    <li class="list-group-item text-center"><h1 class='h2'>Connexion</h1></li>
    <form class='' action="" method="POST">
    <li class="list-group-item">
      
          <div class="form-group text-center">
              <label for="login">Entrez votre pseudo ou votre adresse mail</label>
              <input type="text" class="form-control text-center" id="login" name='login'>
          </div>
        <div class="form-group text-center">
          <label for="pass">Entrez votre mot de passe</label>
          <input type="password" class="form-control text-center" id="pass" name='pass'>
        </div>
    </li>
    <li class="list-group-item">
      <div class='text-center mb-2'>
        <button type="submit" class="btn btn-primary" name='connexion'>Connectez vous <i class="fas fa-check"></i></button>
      </div>
      <?php if(isset($_SESSION['user'])){ ?>
      <!-- <div class='text-center'>
       <a href='inscription.php' class="btn btn-primary" >Pas encore inscrit ? Inscrivez-vous ! <i class="fas fa-arrow-right"></i></a>
      </div> -->
      <?php } ?>
    </li>
  </ul>
</div>
</div>
</form>
<div class='col-6 offset-3 text-center'>
<?php if(isset($erreur)){echo $erreur;}?>
</div>
<?php
$contenu = ob_get_clean();
require_once('./views/template2.php');
?>