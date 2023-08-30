<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class UserRequest
{

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Email]
    private string $email;
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 8)]
    private string $password;
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private array $roles;

    public function __construct(string $email, string $password, array $roles)
    {
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}