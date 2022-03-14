<?php

namespace App\Manager;

use App\Entity\Housing;
use App\Entity\Rent;
use App\Entity\User;
use App\Exception\UnavailableHousingException;
use App\Repository\RentRepository;
use Doctrine\ORM\EntityManagerInterface;

class RentManager
{
    private EntityManagerInterface $entityManager;

    private RentRepository $rentRepository;

    public function __construct(EntityManagerInterface $entityManager, RentRepository $rentRepository)
    {
        $this->entityManager = $entityManager;
        $this->rentRepository = $rentRepository;
    }

    public function make(User $renter, \DateTime $from, \DateTime $to, Housing $housing): Rent
    {
        $isAvailable = $this->rentRepository->isAvailable($housing, $from, $to);

        if (!$isAvailable) {
            throw UnavailableHousingException::housingNotAvailable($housing, $from, $to);
        }
        $rent = new Rent($housing, $from, $to, $renter);

        $this->entityManager->persist($rent);
        $this->entityManager->flush();

        $renter->addRent($rent);
        $housing->addRent($rent);
        $this->entityManager->persist($renter);
        $this->entityManager->persist($housing);
        $this->entityManager->flush();

        return $rent;
    }

    public function cancel(Rent $rent): bool
    {
        $success = true;
        $renter = $rent->getRenter();
        $housing = $rent->getHousing();

        $success |= $renter->removeRent($rent);
        $success |= $housing->removeRent($rent);

        $this->entityManager->persist($renter);
        $this->entityManager->persist($housing);
        $this->entityManager->remove($rent);

        $this->entityManager->flush();

        return $success;
    }
}