<?php
require_once './controllers/backend/AuthController.php';
require_once './commons/connexion_BDD.php';
require_once './models/backend/BackDriver.php';
require_once './models/Categories.class.php';

class CategorieController {

    private $driver;

    public function __construct($bdd)
    {
        $this->driver = new BackDriver($bdd);
    }

    public function getCategories($search) 
    {
        if(AuthController::isLogged())
        {
        $data = $this->driver->listeCategories($search);
       //return $data;
        require_once './views/backend/displayCategories.php';
        }else
        {
            header('location:./index.php?action=connexion');
        }
    }

    public function setCategorie() 
    {
        if(AuthController::isLogged())
        {
        if(isset($_POST['add']) && isset($_POST['categorie']) && strlen($_POST['categorie']) >=2)
        {
            $recup_categorie = trim(htmlspecialchars(addslashes($_POST['categorie'])));
        
            $categorie = new Categories();

            $categorie->setNomCat($recup_categorie);
            $result = $this->driver->addCategorie($categorie);
        
            if($result)
            {
                header('location:index.php?action=listCategories');
            }else
            {
                echo '<div class="alert alert-danger">
                            <strong>Erreur lors de la création de la catégorie.</strong>
                            </div>';
            }
        
        }else
        {
            header('location:index.php?action=addCategorie');
        }
        }else
        {
            header('location:./index.php?action=connexion');
        }
    }

    public function formAddCategorie() 
    {
        if(AuthController::isLogged())
        {
        require_once './views/backend/addCategorie.php';
        }else
        {
            header('location:./index.php?action=connexion');
        }
    }

    
    
}

