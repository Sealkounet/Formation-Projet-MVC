<?php

Class User
{
    private $ID_users;
    private $nom;
    private $prenom;
    private $email;
    private $pseudo;
    private $pass;
    private $role;


    //GETTERS
    public function getID_users()
    {
        return $this->ID_users;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function getRole()
    {
        return $this->role;
    }


    //SETTERS
    public function setID_users($ID_users)
    {
        $this->ID_users = $ID_users;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }
}