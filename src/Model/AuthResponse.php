<?php

namespace App\Model;

class AuthResponse
{
    private string $email;
    private array $roles;
    public function __construct(string $email, array $roles)
    {
        $this->email = $email;
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
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}