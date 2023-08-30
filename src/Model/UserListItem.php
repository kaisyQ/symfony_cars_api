<?php

namespace App\Model;

class UserListItem
{
    private string $email;
    private string $id;
    private array $roles;
    public function __construct(string $email, string $id, array $roles)
    {
        $this->email = $email;
        $this->id = $id;
        $this->roles = $roles;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}