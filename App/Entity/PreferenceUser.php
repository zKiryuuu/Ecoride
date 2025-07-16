<?php

namespace App\Entity;

class PreferenceUser extends Entity
{
    protected int $id;
    protected ?string $preference_personnelle = "";
    protected ?string $preference_id = "";
    protected string $user_id;

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
     * Get the value of preference_personnelle
     */
    public function getPreferencePersonnelle(): ?string
    {
        return $this->preference_personnelle;
    }

    /**
     * Set the value of preference_personnelle
     */
    public function setPreferencePersonnelle(?string $preference_personnelle): self
    {
        $this->preference_personnelle = $preference_personnelle;

        return $this;
    }

    /**
     * Get the value of preference_id
     */
    public function getPreferenceId(): ?string
    {
        return $this->preference_id;
    }

    /**
     * Set the value of preference_id
     */
    public function setPreferenceId(?string $preference_id): self
    {
        $this->preference_id = $preference_id;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     */
    public function setUserId(string $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}