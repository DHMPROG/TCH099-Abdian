<?php

class Utilisateur implements JsonSerializable
{
    private int $id;
    private string $prenom;
    private string $nom;
    private string $email;
    private string $motDePasse;
    private string $motDePasseEnClair;
    private string $telephone;
    private DateTime $dateInscription;
    private Role $role;

    public function __construct(
        string $prenom,
        string $nom,
        string $email,
        string $motDePasse,
        string $motDePasseEnClair,
        string $telephone
    ) {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->motDePasse = password_hash($motDePasse, PASSWORD_BCRYPT);
        $this->motDePasseEnClair = $motDePasseEnClair;
        $this->telephone = $telephone;
        $this->dateInscription = new DateTime();
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    public function getMotDePasseEnClair(): string
    {
        return $this->motDePasseEnClair;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getDateInscription(): DateTime
    {
        return $this->dateInscription;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setMotDePasse(string $motDePasse): void
    {
        $this->motDePasse = password_hash($motDePasse, PASSWORD_BCRYPT);
    }

    public function setMotDePasseEnClair(string $motDePasseEnClair): void
    {
        $this->motDePasseEnClair = $motDePasseEnClair;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getRole(): Role
    {
        return $this->role;
    }
    public function setRole(Role $role): void
    {
        if (in_array($role->getRoleName(), ['Client', 'Admin'])) {
            $this->role = $role;
        } else {
            throw new InvalidArgumentException("Invalid role.");
        }
    }
    // Method to verify password
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->motDePasse);
    }

    // Method to hash the password
    public function hashPassword(): void
    {
        $this->motDePasse = password_hash($this->motDePasseEnClair, PASSWORD_BCRYPT);
    }

    // __toString method
    public function __toString(): string
    {
        return sprintf(
            "[Utilisateur #%d] %s %s - %s (%s)",
            $this->id,
            $this->prenom,
            $this->nom,
            $this->email,
            $this->telephone ?? "No phone"
        );
    }

    // Method to serialize to JSON
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'email' => $this->email,
            // Do not include the password for security reasons
            'telephone' => $this->telephone,
            'dateInscription' => $this->dateInscription->format(DateTime::ATOM),
        ];
    }
}