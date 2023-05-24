<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $super_admin = $this->createAdmin();

        $manager->persist($super_admin);
        $manager->flush();
    }

    private function createAdmin() {

        $super_admin = new User();

        $password_hashed = $this->userPasswordHasher->hashPassword($super_admin, "azerty1234A*");

        $super_admin->setFirstName("Sakinah");
        $super_admin->setLastName("Gros Tête");
        $super_admin->setEmail("Sakinahgrostete@gmail.com");
        $super_admin->setPhone("0699098765");
        $super_admin->setPassword($password_hashed);
        $super_admin->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN', 'ROLE_USER']);
        $super_admin->setIsVerified(true);
        $super_admin->setVerifiedAt(new \DateTimeImmutable('now'));

        return $super_admin;
    }
}
