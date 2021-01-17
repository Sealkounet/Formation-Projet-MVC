<?php
require_once './models/Driver.class.php';

class BackDriver extends Driver {

    public function __construct($bdd)
    {

        parent::__construct($bdd);
    }

    public function addCategorie(Categories $categories){
        $sql = "INSERT INTO categories(nomCat) VALUES (:nomCat)";
        $resultat = $this->bdd->prepare($sql);
        $resultat->execute(array('nomCat'=>$categories->getNomCat()));
        return $this->bdd->lastInsertId();   
    }

    public function addVehicule(Vehicule $vehicule){
        $sql = "INSERT INTO vehicules(marque ,modele ,pays ,prix ,annee, image, idCat) VALUES (:marque, :modele, :pays, :prix, :annee, :image, :idCat)";
        $resultat = $this->bdd->prepare($sql);
        $tabVehicule = ['marque'=>$vehicule->getMarque(),'modele'=>$vehicule->getModele(),'pays'=>$vehicule->getPays(),'prix'=>$vehicule->getPrix(),'annee'=>$vehicule->getAnnee(), 'image'=>$vehicule->getImage(),'idCat'=>$vehicule->getIdCat()];
        $resultat->execute($tabVehicule);
        $resultat->closeCursor();
        return $this->bdd->lastInsertId();
    }

    public function deleteVehicule(Vehicule $vehicule){
        $sql = "DELETE FROM vehicules WHERE idVehicule = :idVehicule";
        $resultat = $this->bdd->prepare($sql);
        $resultat->execute(array('idVehicule'=>$vehicule->getIdVehicule()));
        $resultat->closeCursor();
    }

    public function displayUpdateVehicule($id){
        $sql = "SELECT * FROM vehicules WHERE idVehicule = :idVehicule";
        $resultat = $this->bdd->prepare($sql);
        $resultat->execute(array('idVehicule'=>$id));
        
        $row = $resultat->fetch(PDO::FETCH_OBJ);
        $vehicule = new Vehicule();
        $vehicule->setIdVehicule($row->idVehicule);
        $vehicule->setMarque($row->marque);
        $vehicule->setModele($row->modele);
        $vehicule->setPays($row->pays);
        $vehicule->setPrix($row->prix);
        $vehicule->setAnnee($row->annee);
        $vehicule->setImage($row->image);
        $vehicule->setIdCat($row->idCat);
        $vehicule->nomCat = $this->recupNomCat($row->idCat);
        $resultat->closeCursor();
        return $vehicule;
    }

    public function updateVehicule(Vehicule $vehicule){
        if($vehicule->getImage() == ""){
            $sql = "UPDATE vehicules SET marque = :marque, modele = :modele, pays = :pays, prix = :prix, annee = :annee, idCat = :idCat WHERE idVehicule = ".$vehicule->getIdVehicule();
            $tabVehicule = ['marque'=>$vehicule->getMarque(),'modele'=>$vehicule->getModele(),'pays'=>$vehicule->getPays(),'prix'=>$vehicule->getPrix(),'annee'=>$vehicule->getAnnee(),'idCat'=>$vehicule->getIdCat()];
        }else{ 
            $sql = "UPDATE vehicules SET marque = :marque, modele = :modele, pays = :pays, prix = :prix, annee = :annee, image = :image, idCat = :idCat WHERE idVehicule = ".$vehicule->getIdVehicule();
            $tabVehicule = ['marque'=>$vehicule->getMarque(),'modele'=>$vehicule->getModele(),'pays'=>$vehicule->getPays(),'prix'=>$vehicule->getPrix(),'annee'=>$vehicule->getAnnee(), 'image'=>$vehicule->getImage(),'idCat'=>$vehicule->getIdCat()];
        }
        $resultat = $this->bdd->prepare($sql);
        $resultat->execute($tabVehicule);
        
    }

    public function getUsers(User $user)
    {
        $sql = "SELECT * FROM users WHERE (pseudo = :pseudo AND pass = :pass) OR (email = :email AND pass = :pass)";
        $resultat = $this->bdd->prepare($sql);
        $resultat->execute(['pseudo'=>$user->getPseudo(),'pass'=>$user->getPass(),'email'=>$user->getEmail()]);
        if($resultat->rowCount() != 0){
            $row = $resultat->fetch();
            
            $newUser = new User();
            $newUser->setID_users($row['ID_users']);
            $newUser->setPseudo($row['pseudo']);
            $newUser->setPass($row['pass']);
            $newUser->setEmail($row['email']);
            $newUser->nb = $resultat->rowCount();
            //$newUser->setRole($row['role']);
            
            return $newUser;
        }
    }

}


?>