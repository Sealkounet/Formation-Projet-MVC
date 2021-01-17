<?php
session_start();
require_once './commons/connexion_BDD.php';
require_once './models/backend/BackDriver.php';
require_once './models/User.php';

class UsersController 
{
    private $driver;

    public function __construct($bdd)
    {
        $this->driver = new BackDriver($bdd);
    }

    public function login()
    {
        if(isset($_POST['connexion']))
        {
            if(!empty($_POST['login']) && !empty($_POST['pass']))
            {

            $login = trim(htmlentities(addslashes($_POST['login'])));
            $pass = md5(trim(htmlentities(addslashes($_POST['pass']))));
            $user = new User();

            $user->setPseudo($login);
            $user->setEmail($login);
            $user->setPass($pass);

            $resultat = $this->driver->getUsers($user);
                //var_dump($resultat->nb); die;
                if(isset($resultat->nb)) 
                {
                    $_SESSION['user'] = array('pseudo'=>$resultat->getPseudo(), 'email'=>$resultat->getEmail(), 'pass'=>$resultat->getPass());      
                    header('location:./index.php?action=listVehicules');
                }else
                {
                    $erreur =  '<div class="alert alert-danger">
                    <strong>L\'identifiant et/ou le mot de passe ne sont pas valides.</strong>
                    </div>';
                }
            }else
            {
                $erreur =  '<div class="alert alert-danger">
                  <strong>Veuillez remplir tous les champs.</strong>
                  </div>';
            }

        }
        require_once './views/backend/connexion.php';
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy(); 
        header('location:./index.php?action=connexion');
        exit;
    }
}

?>