<?php


abstract class Driver {
    protected $bdd;
    
    public function __construct($bdd){
        $this->bdd = $bdd;
        $this->getBdd();
    }

    public function getBdd(){
        return $this->bdd;
    }

    //Catégories
    public function listeCategories($search){
        if($search != ""){
            $sql = "SELECT * FROM categories WHERE nomCat LIKE :nomCat";
            $resultat = $this->bdd->prepare($sql);
            $resultat->execute(array('nomCat'=>"$search%"));
        }else{
            $sql = "SELECT * FROM categories";
            $resultat = $this->bdd->prepare($sql);
            $resultat->execute();
        }
        $rows = $resultat->fetchAll(PDO::FETCH_OBJ);
        $resultat->closeCursor();
        $donnees = [];
        $compteur = 0;
        foreach($rows as $value){
            $categorie = new Categories();
            $categorie->setIdCat($value->idCat);
            $categorie->setNomCat($value->nomCat);
            $donnees[$compteur++] = $categorie;
            
        } 
        return $donnees;
    }

    public function recupNomCat($id){
        $sql = "SELECT nomCat FROM categories WHERE idCat = :idCat";
        $resultat = $this->bdd->prepare($sql);
        $resultat->execute(array('idCat'=>$id));
        $row = $resultat->fetch(PDO::FETCH_OBJ);
        return $row->nomCat;
    }


    //Véhicules
    public function listeVehicules($search){
        if($search != ""){
            $sql = "SELECT * FROM vehicules WHERE marque LIKE :marque";
            $resultat = $this->bdd->prepare($sql);
            $resultat->execute(array('marque'=>"$search%"));
        }else{
            $sql = "SELECT * FROM vehicules";
            $resultat = $this->bdd->prepare($sql);
            $resultat->execute();

        }
        $rows = $resultat->fetchAll(PDO::FETCH_OBJ);
        $data = [];
        $compteur = 0;
        foreach($rows as $value){
            $vehicule = new Vehicule();
            
            $vehicule->setIdVehicule($value->idVehicule);
            $vehicule->setMarque($value->marque);
            $vehicule->setModele($value->modele);
            $vehicule->setPays($value->pays);
            $vehicule->setPrix($value->prix);
            $vehicule->setAnnee($value->annee);
            $vehicule->setImage($value->image);
            $vehicule->setIdCat($this->recupNomCat($value->idCat));
            $vehicule->setStatus($value->status);
            $data[$compteur++] = $vehicule;
        }
        $resultat->closeCursor();
        return $data;
    }

    public function switchStatus(Vehicule $vehicule){
            $sql = "UPDATE vehicules SET status = :status WHERE idVehicule =".$vehicule->getIdVehicule();
            $resultat = $this->bdd->prepare($sql);
            $resultat->execute(array('status'=>$vehicule->getStatus()));           
    }

   
}
