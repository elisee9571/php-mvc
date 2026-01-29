<?php

namespace App\Model;

use DateTime;

class User
{
    private ?int $id = null;

    private ?string $picture = null;

    private string $username;

    private string $email;

    private string $password;

    private string $created_at;

    private string $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): User
    {
        $this->picture = $picture;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function getUpdatedAt(): DateTime
    {
        return new DateTime($this->updated_at);
    }
}
