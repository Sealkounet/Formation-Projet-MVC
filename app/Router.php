<?php
require_once './commons/connexion_BDD.php';
require_once './controllers/backend/CategorieController.php';
require_once './controllers/backend/VehiculeController.php';
require_once './controllers/backend/UsersController.php';
require_once './controllers/frontend/PublicController.php';

class Router {

    private $ctrlCategories;
    private $ctrlVehicules;
    private $ctrlUsers;
    private $ctrlPublic;

    public function __construct($bdd)
    {
        $this->ctrlCategories = new CategorieController($bdd);
        $this->ctrlVehicules = new VehiculeController($bdd);
        $this->ctrlUsers = new UsersController($bdd);
        $this->ctrlPublic = new PublicController($bdd);
    }

    public function reqUrl() 
    {
    try
    {
        if (isset($_GET['action'])) 
        {
            if ($_GET['action'] == 'listCategories') 
            {
                if ($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    $this->ctrlCategories->getCategories($_POST['search']);
                }else
                {
                    $this->ctrlCategories->getCategories('');
                }
            }else if ($_GET['action'] == 'addCategorie')
            {
                if ($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    $this->ctrlCategories->setCategorie();
                }
                else
                {
                    $this->ctrlCategories->formAddCategorie();
                }
            }else if ($_GET['action'] == 'listVehicules')
            {
                if ($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    $this->ctrlVehicules->getVehicules($_POST['search']);
                }else
                {
                    $this->ctrlVehicules->getVehicules('');
                }
            }else if ($_GET['action'] == 'update') 
            {
                if (isset($_GET['id'])) 
                {
                    $id = (int)trim(htmlentities(addslashes($_GET['id'])));
                    if ($id != 0) 
                    {
                        if($_SERVER['REQUEST_METHOD'] === 'POST')
                        {
                            $this->ctrlVehicules->setUpdateVehicule($id);
                        }
                        $this->ctrlVehicules->getDisplayUpdateVehicule($id);
                        
                    }
                }
                
            }else if ($_GET['action'] == 'addVehicule')
            {
                if ($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    $this->ctrlVehicules->setVehicule();
                }else
                {
                    $this->ctrlVehicules->formAddVehicule();
                }
                
            }else if ($_GET['action'] == 'delete')
            {
                if (isset($_GET['id']) && isset($_GET['img']))
                {
                $id = (int)trim(htmlentities(addslashes($_GET['id']))); 
                $img = trim(htmlspecialchars(addslashes($_GET['img'])));
                
                    if ($id != 0 && $img != '')
                    {   
                        $this->ctrlVehicules->setDeleteVehicule($id, $img); 
                    } 
                }
            }else if ($_GET['action'] == 'switch')
            {
                if(isset($_GET['id']) && !empty($_GET['id']))
                {
                    $id = (int)trim(htmlspecialchars(addslashes($_GET['id'])));
                    $status= (int)trim(htmlspecialchars(addslashes($_GET['status'])));
                    $this->ctrlVehicules->changeStatus($id,$status); 
                    
                }
            }else if($_GET['action'] == 'connexion')
            {
                $this->ctrlUsers->login();

            }else if($_GET['action'] == 'logout')
            {
                $this->ctrlUsers->logout();
            }else if($_GET['action'] == 'recapitulatif')
            {
                if($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    $this->ctrlPublic->stripe();
                }else
                {
                    $this->ctrlPublic->recap();
                }

            }else
            {
                throw new Exception('Action non valide.');
            }


        }else
        {
            $this->ctrlPublic->accueil();
        }
    }catch(Exception $ex)
    {
        //echo $ex->getMessage();
        $this->page404($ex->getMessage());
    }
}

    private function page404($msgErreur){
        require_once './views/page404.php';
    }
}

?>