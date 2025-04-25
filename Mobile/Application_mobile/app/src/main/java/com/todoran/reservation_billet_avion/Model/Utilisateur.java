package com.todoran.reservation_billet_avion.Model;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;

@JsonIgnoreProperties({"nom", "prenom", "age", "telephone"})
public class Utilisateur {

    private String email;
    private String motDePasse;  // Renommé de "mdp" à "motDePasse"
    private String nom;
    private String prenom;
    private int age;
    private String telephone;

    // Constructeur avec tous les paramètres
    public Utilisateur(String email, String motDePasse, String nom, String prenom, int age, String telephone) {
        this.email = email;
        this.motDePasse = motDePasse;  // Utilisation de "motDePasse"
        this.nom = nom;
        this.prenom = prenom;
        this.age = age;
        this.telephone = telephone;
    }

    // Constructeur par défaut
    public Utilisateur() {}

    // Constructeur avec email et motDePasse seulement
    public Utilisateur(String email, String motDePasse){
        this.email = email;
        this.motDePasse = motDePasse;  // Utilisation de "motDePasse"
    }

    // Getters et setters
    public String getEmail(){
        return email;
    }

    public String getMotDePasse(){
        return motDePasse;  // Utilisation de "motDePasse"
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public void setMotDePasse(String motDePasse) {
        this.motDePasse = motDePasse;  // Utilisation de "motDePasse"
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public int getAge() {
        return age;
    }

    public void setAge(int age) {
        this.age = age;
    }

    public String getTelephone() {
        return telephone;
    }

    public void setTelephone(String telephone) {
        this.telephone = telephone;
    }
}
