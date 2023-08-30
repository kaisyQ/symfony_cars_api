<?php

namespace App\Service;

use App\Entity\User;
use App\Model\UserResponse;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
    private Security $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function login(): ?UserResponse {
        $user = $this->security->getUser();

        return new UserResponse(
            $user->getUserIdentifier(),
            $user->getRoles()
        );
    }

    public function checkMe (): ?UserResponse {

        $user = $this->security->getUser();

        if (!$user) {
            return null;
        }

        return new UserResponse(
            $user->getUserIdentifier(),
            $user->getRoles()
        );
    }

    public function logout(): void {
        $this->security->logout(false);
    }
}