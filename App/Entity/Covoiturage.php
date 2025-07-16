<?php

namespace App\Entity;

use DateTime;

class Covoiturage extends Entity
{
    protected int $id;
    protected ?int $nb_place_disponible = 0;
    protected ?float $prix = 0;
    protected ?DateTime $date_heure_depart = null;
    protected ?DateTime $date_heure_arrivee = null;
    protected string $adresse_depart;
    protected string $adresse_arrivee;
    protected int $voiture_id;
    protected ?int $statut_id = 1;


    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nb_place_disponible
     */
    public function getNbPlaceDisponible(): ?int
    {
        return $this->nb_place_disponible;
    }

    /**
     * Set the value of nb_place_disponible
     */
    public function setNbPlaceDisponible(?int $nb_place_disponible): self
    {
        $this->nb_place_disponible = $nb_place_disponible;
        return $this;
    }

    /**
     * Get the value of prix
     */
    public function getPrix(): ?float
    {
        return $this->prix;
    }

    /**
     * Set the value of prix
     */
    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get the value of date_heure_depart
     */
    public function getDateHeureDepart(): ?DateTime
    {
        return $this->date_heure_depart;
    }

    /**
     * Set the value of date_heure_depart
     */
    public function setDateHeureDepart(?DateTime $date_heure_depart): self
    {
        $this->date_heure_depart = $date_heure_depart;

        return $this;
    }

    /**
     * Get the value of date_heure_arrivee
     */
    public function getDateHeureArrivee(): ?DateTime
    {
        return $this->date_heure_arrivee;
    }

    /**
     * Set the value of date_heure_arrivee
     */
    public function setDateHeureArrivee(?DateTime $date_heure_arrivee): self
    {
        $this->date_heure_arrivee = $date_heure_arrivee;

        return $this;
    }

    /**
     * Get the value of adresse_depart
     */
    public function getAdresseDepart(): string
    {
        return $this->adresse_depart;
    }

    /**
     * Set the value of adresse_depart
     */
    public function setAdresseDepart(string $adresse_depart): self
    {
        $this->adresse_depart = $adresse_depart;

        return $this;
    }

    /**
     * Get the value of adresse_arrivee
     */
    public function getAdresseArrivee(): string
    {
        return $this->adresse_arrivee;
    }

    /**
     * Set the value of adresse_arrivee
     */
    public function setAdresseArrivee(string $adresse_arrivee): self
    {
        $this->adresse_arrivee = $adresse_arrivee;

        return $this;
    }

    /**
     * Get the value of voiture_id
     */
    public function getVoitureId(): int
    {
        return $this->voiture_id;
    }

    /**
     * Set the value of voiture_id
     */
    public function setVoitureId(int $voiture_id): self
    {
        $this->voiture_id = $voiture_id;

        return $this;
    }

    /**
     * Get the value of statut_id
     */
    public function getStatutId(): ?int
    {
        return $this->statut_id;
    }

    /**
     * Set the value of statut_id
     */
    public function setStatutId(?int $statut_id): self
    {
        $this->statut_id = $statut_id;

        return $this;
    }
}
