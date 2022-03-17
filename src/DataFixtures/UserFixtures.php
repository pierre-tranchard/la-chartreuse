<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Yaml\Yaml;

class UserFixtures extends Fixture
{
    private PasswordHasherInterface $passwordHasher;

    public function __construct(PasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $users = Yaml::parseFile(__DIR__ . "/Users.yaml")["Users"] ?? [];
        foreach ($users as $username => $attributes) {
            $user = new User();
            $user
                ->setUsername($username)
                ->setLastName($attributes["lastName"])
                ->setFirstName($attributes["firstName"])
                ->setEmail($attributes["email"])
                ->setPassword($this->passwordHasher->hash("changeme"))
                ->setBirthDate(\DateTime::createFromFormat("Y-m-d", $attributes["birthDate"]));

            $this->addReference($username, $user);
            $manager->persist($user);
        }
        $manager->flush();
    }
}