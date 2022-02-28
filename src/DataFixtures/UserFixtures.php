<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class UserFixtures extends Fixture
{
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
                ->setPassword("changeme")
                ->setBirthDate(\DateTime::createFromFormat("Y-m-d", $attributes["birthDate"]));

            $this->addReference($username, $user);
            $manager->persist($user);
        }
        $manager->flush();
    }
}