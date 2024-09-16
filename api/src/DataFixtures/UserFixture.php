<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(
        public readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $user_num = 10;
        $i=1;
        while ($i <= $user_num) {
            $user = new User();
            $user->setEmail("user{$i}@example.com");
            $user->setRoles(["ROLE_USER"]);

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                "password{$i}"
            );
            $user->setPassword($hashedPassword);

            $manager->persist($user);
            $i++;
        }

        $manager->flush();
    }
}
