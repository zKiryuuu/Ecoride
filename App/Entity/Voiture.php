<?php

namespace App\Entity;

use DateTime;

class Voiture extends Entity
{
    protected ?int $id = null;
    protected string $modele = "";
    protected string $couleur = "";
    protected string $marque = "";
    protected string $immatriculation = "";
    protected ?DateTime $date_premiere_immatriculation = null;
    protected int $user_id;
    protected ?int $energie_id = null;

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
     * Get the value of model
     */
    public function getModele(): string
    {
        return $this->modele;
    }

    /**
     * Set the value of model
     */
    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get the value of couleur
     */
    public function getCouleur(): string
    {
        return $this->couleur;
    }

    /**
     * Set the value of couleur
     */
    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get the value of marque
     */
    public function getMarque(): string
    {
        return $this->marque;
    }

    /**
     * Set the value of marque
     */
    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get the value of immatriculation
     */
    public function getImmatriculation(): string
    {
        return $this->immatriculation;
    }

    /**
     * Set the value of immatriculation
     */
    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    /**
     * Get the value of date_premiere_immatriculation
     */
    public function getDatePremiereImmatriculation(): ?DateTime
    {
        return $this->date_premiere_immatriculation;
    }

    /**
     * Set the value of date_premiere_immatriculation
     */
    public function setDatePremiereImmatriculation(?DateTime $date_premiere_immatriculation): self
    {
        $this->date_premiere_immatriculation = $date_premiere_immatriculation;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     */
    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of energie_id
     */
    public function getEnergieId(): ?int
    {
        return $this->energie_id;
    }

    /**
     * Set the value of energie_id
     */
    public function setEnergieId(?int $energie_id): self
    {
        $this->energie_id = $energie_id;

        return $this;
    }
}
