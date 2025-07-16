<?php

namespace App\Entity;

class User extends Entity
{
    protected ?int $id = null;
    // A la création du compte, l’utilisateur bénéficie de 20 crédits.
    protected int $nb_credits;
    protected int $active; // 0 = inactif, 1 = actif
    protected string $pseudo = "";
    protected string $mail = "";
    protected string $password = "";
    protected ?string $photo = "";
    protected ?string $photo_uniqId = "";
    protected ?string $role_id = "";
    
    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nb_credits
     */
    public function getNbCredits(): int
    {
        return $this->nb_credits;
    }

    /**
     * Set the value of nb_credits
     */
    public function setNbCredits(int $nb_credits): self
    {
        $this->nb_credits = $nb_credits;

        return $this;
    }

    /**
     * Get the value of pseudo
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * Set the value of pseudo
     */
    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get the value of mail
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     */
    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of photo
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * Set the value of photo
     */
    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get the value of role_id
     */
    public function getRoleId(): ?string
    {
        return $this->role_id;
    }

    /**
     * Set the value of role_id
     */
    public function setRoleId(?string $role_id): self
    {
        $this->role_id = $role_id;

        return $this;
    }

    /**
     * Get the value of photo_uniqId
     */
    public function getPhotoUniqId(): ?string
    {
        return $this->photo_uniqId;
    }

    /**
     * Set the value of photo_uniqId
     */
    public function setPhotoUniqId(?string $photo_uniqId): self
    {
        $this->photo_uniqId = $photo_uniqId;

        return $this;
    }

    /**
     * Get the value of active
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * Set the value of active
     */
    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }
}
