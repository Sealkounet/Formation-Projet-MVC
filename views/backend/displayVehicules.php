<?php
ob_start();
?>
<h2 class="text-center">Listes des Vehicules</h2>
<form action="" method="POST">
<div class="input-group mb-2 justify-content-end">
        <input class="form-control col-4 text-center" type="search" id="search" placeholder="Rechercher un Véhicule par Marque" name='search'>
        <div class="input-group-append">
            <button class="input-group-text bg-success border-success" type='submit'><i class="fas fa-search text-white"></i></button>
        </div>
    </div>
</form>
<table class="table table-bordered table-striped  text-center">
<thead class="thead-dark">
    <tr>
    <th hidden>N°</th>
    <th>Catégorie</th>
    <th>Marque</th>
    <th>Modèle</th>
    <th>Pays</th>
    <th>Prix</th>
    <th>Année</th>
    <th>Image</th>
    <th>Actions</th>
    </tr>
</thead>
<tbody>
    <?php
        foreach($data as $value){
    ?>
    <tr>
        <td hidden class='align-middle'><?= $value->getIdVehicule(); ?></td>
        <td class='align-middle'><?= $value->getIdCat(); ?></td>
        <td class='align-middle'><?= $value->getMarque(); ?></td>
        <td class='align-middle'><?= $value->getModele(); ?></td>
        <td class='align-middle'><?= $value->getPays(); ?></td>
        <td class='align-middle'><?= $value->getPrix(); ?>€</td>
        <td class='align-middle'><?= $value->getAnnee(); ?></td>
        <td class='align-middle'><img src="./assets/images/<?= $value->getImage(); ?>" alt="monImage" width='100px' height='80px'></td>
        <td class='align-middle'>
            <a href='./index.php?action=update&id=<?= $value->getIdVehicule(); ?>' class='btn btn-info'><i class='fas fa-pen text-white'></i></a>
            <?php if($value->getStatus() == 1){ ?>
                <a class='btn btn-success' href="./index.php?action=switch&id=<?= $value->getIdVehicule(); ?>&status=<?= $value->getStatus(); ?>"><i class='fas fa-check text-white'></i></a>
            <?php }else{ ?>
                <a class='btn btn-warning' href="./index.php?action=switch&id=<?= $value->getIdVehicule(); ?>&status=<?= $value->getStatus(); ?>"><i class='fas fa-ban text-white'></i></a>
            <?php } ?>
            <a class='btn btn-danger' onclick="return confirm('Etes-vous sûr de vouloir supprimer ce véhicule ? Cette action est irréversible !')" href="./index.php?action=delete&img=<?= $value->getImage(); ?>&id=<?= $value->getIdVehicule(); ?>"><i class='fas fa-trash' style='color:white'></i></a>
        </td>
        
    </tr>
    <?php
        }
    ?>
</tbody>
</table>

<?php 
$contenu = ob_get_clean();
require_once ('template.php');
?>
