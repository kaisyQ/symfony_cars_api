<?php

use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\UserService;
use App\Model\UserListResponse;
use App\Model\UserListItem;
class UserServiceTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetUsers () : void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);
        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);


        $user1 = new User();
        $user1->setId(1);
        $user1->setEmail('example@gmail.com');
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword($passwordHasher->hashPassword($user1,'123456789'));

        $user2 = new User();
        $user2->setId(2);
        $user2->setEmail('example1@gmail.com');
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setPassword($passwordHasher->hashPassword($user1,'password1123'));


        $userRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([$user1, $user2]);

        $expected = new UserListResponse(
            [
                new UserListItem('example@gmail.com', 1, ['ROLE_USER']),
                new UserListItem('example1@gmail.com', 2, ['ROLE_ADMIN', 'ROLE_USER'])
            ]
        );

        $service = new UserService($userRepository, $passwordHasher, $em);


        $this->assertEquals($expected, $service->getUsers());
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetUserByEmail () : void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);
        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);


        $user = new User();
        $user->setId(1);
        $user->setRoles(['ROLE_MANAGER']);
        $user->setEmail('example@gmail.com');
        $user->setPassword($passwordHasher->hashPassword($user, '213455161'));
        $userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with('example@gmail.com')
            ->willReturn($user);

        $service = new UserService($userRepository, $passwordHasher, $em);

        $expected = new UserListItem(
            'example@gmail.com',
            1,
            ['ROLE_MANAGER', 'ROLE_USER']
        );

        $this->assertEquals($expected, $service->getUserByEmail('example@gmail.com'));
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testCreateUser () : void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);
        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);

        $service = new UserService($userRepository, $passwordHasher, $em);

        $user = new User();
        $user->setId(1);
        $user->setRoles(['ROLE_MANAGER']);
        $user->setEmail('example@mail.ru');
        $user->setPassword($passwordHasher->hashPassword($user, '213455161'));

        $userRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([
                $user
            ]);

        $expected = new UserListItem(
            'example@gmail.com',
            2,
            ['ROLE_ADMIN', 'ROLE_USER']
        );

        $this->assertEquals($expected, $service->createUser((object)[
            'email' => 'example@gmail.com',
            'password' => 'Toyota123',
            'roles' => ['ROLE_ADMIN']
        ]));
    }

    public function testDeleteUser () : void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);
        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);


        $user = new User();
        $user->setId(1);
        $user->setRoles(['ROLE_MANAGER']);
        $user->setEmail('example@gmail.com');
        $user->setPassword($passwordHasher->hashPassword($user, '213455161'));
        $userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with('example@gmail.com')
            ->willReturn($user);

        $service = new UserService($userRepository, $passwordHasher, $em);

        $this->assertEquals('example@gmail.com', $service->deleteUser('example@gmail.com'));
    }
}