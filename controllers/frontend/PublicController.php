<?php
require_once './assets/libraries/stripe/vendor/autoload.php';
require_once './commons/connexion_BDD.php';
require_once './models/frontend/FrontDriver.php';
require_once './models/Vehicule.class.php';

class PublicController
{
    private $driver;

    public function __construct($bdd)
    {
        $this->driver = new FrontDriver($bdd);
    }

    public function accueil()
    {
        
        $dataCat = $this->driver->listeCategories('');
        $dataV = $this->driver->listeVehicules('');
        require_once './views/frontend/accueil.php';
    }

    public function recap()
    {
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = (int)trim(htmlspecialchars(addslashes($_GET['id'])));
            $prix = (int)trim(htmlspecialchars(addslashes($_GET['prix'])));
            $modele = trim(htmlspecialchars(addslashes($_GET['modele'])));
        }
        require_once './views/frontend/recapitulatif.php';
    }

    public function stripe()
    {
        if(isset($_POST["stripeToken"]) && !empty($_POST["stripeToken"])){
            $prix = (int)trim(htmlspecialchars(addslashes($_POST['prix'])));
            $token = $_POST["stripeToken"];
            $id = (int)trim(htmlspecialchars(addslashes($_POST['id'])));
            \Stripe\Stripe::setApiKey("");
            $charge = \Stripe\Charge::create([
                'amount'=> $prix.'00',
                'currency'=>'eur',
                'description'=> 'Achat et Vente de vehicules.',
                'source'=> $token
            ]);
        }
        
        if($charge){
            $vehicule = new Vehicule();
            
            $vehicule->setIdVehicule($id);
            $vehicule->setStatus(0);
        
            $this->driver->switchStatus($vehicule);
            
            header('location:./index.php');
        }else{
            echo 'Erreur lors du paiement...';
        }
    }
}
