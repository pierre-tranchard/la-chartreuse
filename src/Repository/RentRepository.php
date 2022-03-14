<?php

namespace App\Repository;

use App\Entity\Housing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class RentRepository extends ServiceEntityRepository
{
    public function isAvailable(Housing $housing, \DateTime $from, \DateTime $to): bool
    {
        $queryBuilder = $this->createQueryBuilder('rent')
            ->select('count(rent.id)')
            ->where('rent.housing = :housing')
            ->andWhere('rent.dateFrom BETWEEN :from AND :to')
            ->orWhere('rent.dateTo BETWEEN :from AND :to');

        $queryBuilder->setParameters(
            [
                'housing' => $housing->getId(),
                'from'    => $from->format('Y-m-d'),
                'to'      => $to->format('Y-m-d'),
            ]
        );

        return $queryBuilder->getQuery()->getSingleScalarResult() === 0;
    }
}