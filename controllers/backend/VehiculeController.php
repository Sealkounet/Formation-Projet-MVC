<?php
require_once './controllers/backend/AuthController.php';
require_once './commons/connexion_BDD.php';
require_once './models/backend/BackDriver.php';
require_once './models/Vehicule.class.php';

class VehiculeController {
    public $driver;

    public function __construct($bdd)
    {
        $this->driver = new BackDriver($bdd);
    }

    public function getVehicules($search)
    {
        if(AuthController::isLogged())
        {
            $data = $this->driver->listeVehicules($search);
            require_once './views/backend/displayVehicules.php'; 
        }else
        {
            header('location:./index.php?action=connexion');
        }
     }

    public function getDisplayUpdateVehicule($id)
    {
        if(AuthController::isLogged())
        {

            $data = $this->driver->displayUpdateVehicule($id);
            $dataCat = $this->driver->listeCategories('');
            require_once './views/backend/updateVehicule.php';
        }else
        {
            header('location:./index.php?action=connexion');
        }
    }

    public function setUpdateVehicule($vehicule)
    {
        if(AuthController::isLogged())
        {

            if(isset($_POST['update']) && isset($_POST['marque']) && !empty($_POST['modele'])){
            $idVehicule = intval(trim(htmlspecialchars(addslashes($_POST['idVehicule']))));
            $marque = trim(htmlspecialchars(addslashes($_POST['marque'])));
            $modele = trim(htmlspecialchars(addslashes($_POST['modele'])));
            $pays = trim(htmlspecialchars(addslashes($_POST['pays'])));
            $prix = intval(trim(htmlspecialchars(addslashes($_POST['prix']))));
            $annee = (int)trim(htmlspecialchars(addslashes($_POST['annee'])));
            $categorie = (int)trim(htmlspecialchars(addslashes($_POST['categorie'])));
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], './assets/images/'.$image);
            
            $vehicule = new Vehicule();
            
            $vehicule->setIdVehicule($idVehicule);
            $vehicule->setMarque($marque);
            $vehicule->setModele($modele);
            $vehicule->setPays($pays);
            $vehicule->setPrix($prix);
            $vehicule->setAnnee($annee);
            $vehicule->setIdCat($categorie);
            $vehicule->setImage($image);
        
            $this->driver->updateVehicule($vehicule);
            header('location:index.php?action=listVehicules');  
            }
        }else
        {
            header('location:./index.php?action=connexion');
        }
    }

    public function setVehicule()
    {
        if(AuthController::isLogged())
        {

            if(isset($_POST['add']) && isset($_POST['marque']) && !empty($_POST['modele']))
            {
                $data = $this->driver->listeCategories('');


            $marque = trim(htmlspecialchars(addslashes($_POST['marque'])));
            $modele = trim(htmlspecialchars(addslashes($_POST['modele'])));
            $pays = trim(htmlspecialchars(addslashes($_POST['pays'])));
            $prix = intval(trim(htmlspecialchars(addslashes($_POST['prix']))));
            $annee = (int)trim(htmlspecialchars(addslashes($_POST['annee'])));
            $categorie = (int)trim(htmlspecialchars(addslashes($_POST['categorie'])));
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], './assets/images/'.$image);
            
            $vehicule = new Vehicule();
            
            $vehicule->setMarque($marque);
            $vehicule->setModele($modele);
            $vehicule->setPays($pays);
            $vehicule->setPrix($prix);
            $vehicule->setAnnee($annee);
            $vehicule->setIdCat($categorie);
            $vehicule->setImage($image);
            
            $result = $this->driver->addVehicule($vehicule);
            if($result)
            {
                header('location:index.php?action=listVehicules');
            }else
            {
                echo '<div class="alert alert-danger">
                            <strong>Erreur lors de l\'ajout d\'un véhicule.</strong>
                            </div>';
            }
        }else
        {
            header('location:index.php?action=addVehicule');
        }
    }else
    {
        header('location:./index.php?action=connexion');
    }
    }

    public function formAddVehicule()
    {
        if(AuthController::isLogged())
        {

            $data = $this->driver->listeCategories('');
            require_once './views/backend/addVehicule.php';
        }else
        {
            header('location:./index.php?action=connexion');
        }
    }

    public function setDeleteVehicule($id, $img)
    {
        if(AuthController::isLogged())
        {

            $vehicule = new Vehicule();
            
        
            $vehicule->setIdVehicule($id);
            $vehicule->setImage($img);
        
            $this->driver->deleteVehicule($vehicule);
            unlink('./assets/images/'.$vehicule->getImage());
            header('location:index.php?action=listVehicules');
        }else
        {
            header('location:./index.php?action=connexion');
        }
    }

    public function changeStatus($id, $status)
    {
        if(AuthController::isLogged())
        {
        $vehicule = new Vehicule();

        $vehicule->setIdVehicule($id);
        
        if($status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        
        $vehicule->setStatus($status);
        $this->driver->switchStatus($vehicule);

        header('location:index.php?action=listVehicules');
        }else
        {
            header('location:./index.php?action=connexion');
        }
    }
        
}

?>