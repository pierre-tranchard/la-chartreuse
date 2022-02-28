<?php

namespace App\DataFixtures;

use App\Entity\Housing;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class HousingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $housings = Yaml::parseFile(__DIR__ . "/Housings.yaml")["Housings"] ?? [];

        foreach ($housings as $name => $attributes) {
            $housing = new Housing();
            $housing
                ->setName($name)
                ->setAddress($attributes["address"])
                ->setZipCode($attributes["zipCode"])
                ->setCity($attributes["city"])
                ->setCountry($attributes["country"])
                ->setCapacity($attributes["capacity"])
                ->setOwner($this->getReference($attributes["owner"]));

            $manager->persist($housing);
            $this->addReference($name, $housing);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}