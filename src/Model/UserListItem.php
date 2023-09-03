<?php

namespace App\Model;

class UserListItem
{
    private string $email;
    private int $id;
    private array $roles;
    public function __construct(string $email, int $id, array $roles)
    {
        $this->email = $email;
        $this->id = $id;
        $this->roles = $roles;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
}