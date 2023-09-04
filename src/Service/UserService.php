<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\NotFoundException;
use App\Model\UserListItem;
use App\Model\UserListResponse;
use App\Model\UserRequest;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $em;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->em = $em;
    }

    public function getUsers(): UserListResponse {

        $users = $this->userRepository->findAll();

        return new UserListResponse(
            array_map(
                fn($user) => new UserListItem(
                    $user->getEmail(),
                    $user->getId(),
                    $user->getRoles()
                ),
                $users
            )
        );
    }

    public function getUserByEmail(string $email): UserListItem {
        $user = $this->userRepository->findByEmail($email);

        return new UserListItem(
            $user->getEmail(),
            $user->getId(),
            $user->getRoles()
        );
    }
    public function createUser($content): UserListItem {

        $userRequest = new UserRequest($content->email, $content->password, $content->roles);

        $user = new User();
        $user->setEmail($userRequest->getEmail());

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $userRequest->getPassword()
        );

        $user->setPassword($hashedPassword);

        $user->setRoles($userRequest->getRoles());

        $this->em->persist($user);
        $this->em->flush();

        $biggestId = $this->userRepository->findAll(['id' => Criteria::DESC])[0]->getId();

        return new UserListItem(
            $user->getEmail(),
            $biggestId + 1,
            $user->getRoles()
        );
    }

    /**
     * @throws NotFoundException
     */
    public function deleteUser(string $email): string {

        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw new NotFoundException();
        }


        $this->em->remove($user);

        $this->em->flush();

        return $email;
    }
}