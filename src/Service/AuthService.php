<?php

namespace App\Service;

use App\Model\AuthResponse;
use Symfony\Bundle\SecurityBundle\Security;

class AuthService
{
    private Security $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function login(): ?AuthResponse {
        $user = $this->security->getUser();

        return new AuthResponse(
            $user->getUserIdentifier(),
            $user->getRoles()
        );
    }

    public function checkMe (): ?AuthResponse {

        $user = $this->security->getUser();

        if (!$user) {
            return null;
        }

        return new AuthResponse(
            $user->getUserIdentifier(),
            $user->getRoles()
        );
    }

    public function logout(): void {
        $this->security->logout(false);
    }
}