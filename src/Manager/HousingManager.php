<?php

namespace App\Manager;

use App\Entity\Housing;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HousingManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOne(int $id): Housing
    {
        $housing = $this->entityManager->find(Housing::class, $id);

        if (!$housing) {
            throw new NotFoundHttpException();
        }

        return $housing;
    }
}