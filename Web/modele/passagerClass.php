<?php

class Passager implements JsonSerializable
{
    private $id;
    private $id_utilisateur;
    private $prenom;
    private $deuxieme_prenom;
    private $nom;
    private $date_naissance;
    private $email;
    private $telephone;


    // Constructor
    public function __construct(
        $prenom,
        $deuxieme_prenom,
        $nom,
        $date_naissance,
        $email,
        $telephone,

    ) {
        $this->id = null; 
        $this->id_utilisateur = null; 
        $this->prenom = $prenom;
        $this->deuxieme_prenom = $deuxieme_prenom;
        $this->nom = $nom;
        $this->date_naissance = $date_naissance;
        $this->email = $email;
        $this->telephone = $telephone;
    }
    public static function withIds(
        int $id,
        int $id_utilisateur,
        string $prenom,
        string $deuxieme_prenom,
        string $nom,
        string $date_naissance,
        string $email,
        string $telephone,
      
    ): self {
        $obj = new self(
            $prenom,
            $deuxieme_prenom,
            $nom,
            $date_naissance,
            $email,
            $telephone,
        );
        $obj->id = $id;
        $obj->id_utilisateur = $id_utilisateur;
        return $obj;
    }
    // Getters and Setters
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur($id_utilisateur)
    {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getDeuxiemePrenom()
    {
        return $this->deuxieme_prenom;
    }

    public function setDeuxiemePrenom($deuxieme_prenom)
    {
        $this->deuxieme_prenom = $deuxieme_prenom;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getDateNaissance()
    {
        return $this->date_naissance;
    }

    public function setDateNaissance($date_naissance)
    {
        $this->date_naissance = $date_naissance;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'id_utilisateur' => $this->id_utilisateur,
            'prenom' => $this->prenom,
            'deuxieme_prenom' => $this->deuxieme_prenom,
            'nom' => $this->nom,
            'date_naissance' => $this->date_naissance,
            'email' => $this->email,
            'telephone' => $this->telephone
        ];
    }
}