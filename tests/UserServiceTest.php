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

}