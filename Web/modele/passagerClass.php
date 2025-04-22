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
    private $urgence_prenom;
    private $urgence_nom;
    private $urgence_email;
    private $urgence_telephone;

    // Constructor
    public function __construct(
        $id_utilisateur,
        $prenom,
        $deuxieme_prenom,
        $nom,
        $date_naissance,
        $email,
        $telephone,
        $urgence_prenom,
        $urgence_nom,
        $urgence_email,
        $urgence_telephone
    ) {
        $this->id_utilisateur = $id_utilisateur;
        $this->prenom = $prenom;
        $this->deuxieme_prenom = $deuxieme_prenom;
        $this->nom = $nom;
        $this->date_naissance = $date_naissance;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->urgence_prenom = $urgence_prenom;
        $this->urgence_nom = $urgence_nom;
        $this->urgence_email = $urgence_email;
        $this->urgence_telephone = $urgence_telephone;
    }

    // Getters and Setters
    public function getId()
    {
        return $this->id;
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

    public function getUrgencePrenom()
    {
        return $this->urgence_prenom;
    }

    public function setUrgencePrenom($urgence_prenom)
    {
        $this->urgence_prenom = $urgence_prenom;
    }

    public function getUrgenceNom()
    {
        return $this->urgence_nom;
    }

    public function setUrgenceNom($urgence_nom)
    {
        $this->urgence_nom = $urgence_nom;
    }

    public function getUrgenceEmail()
    {
        return $this->urgence_email;
    }

    public function setUrgenceEmail($urgence_email)
    {
        $this->urgence_email = $urgence_email;
    }

    public function getUrgenceTelephone()
    {
        return $this->urgence_telephone;
    }

    public function setUrgenceTelephone($urgence_telephone)
    {
        $this->urgence_telephone = $urgence_telephone;
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
            'telephone' => $this->telephone,
            'urgence_prenom' => $this->urgence_prenom,
            'urgence_nom' => $this->urgence_nom,
            'urgence_email' => $this->urgence_email,
            'urgence_telephone' => $this->urgence_telephone,
        ];
    }
}