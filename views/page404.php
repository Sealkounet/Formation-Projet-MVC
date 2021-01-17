<?php
ob_start();
?>

<div class='text-center'>
    <h1>Page 404 !</h1>
    <p><?= $msgErreur; ?></p>
    <!-- <p>Perdu sur la toile ? Pas de panique ! Nous sommes là pour vous guider.</p> -->
    <a class='btn btn-primary' href='./index.php'>Cliquez ici pour retourner à l'accueil.</a>
</div>

<?php
$contenu = ob_get_clean();
require_once './views/template2.php';
?>