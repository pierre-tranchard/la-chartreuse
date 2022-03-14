<?php

namespace App\Repository;

use App\Entity\Housing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;

class RentRepository extends ServiceEntityRepository
{
    public function isAvailable(Housing $housing, \DateTime $from, \DateTime $to): bool
    {
        $queryBuilder = $this->createQueryBuilder('rent')
            ->select('count(rent.id)')
            ->where('rent.housing.id := housing')
            ->andWhere('rent.dateFrom BETWEEN :from AND :to')
            ->orWhere('rent.dateTo BETWEEN :from AND :to');

        $queryBuilder->getQuery()->setParameters(
            [
                'housing' => $housing->getId(),
                'from'    => $from->format('Y-m-d'),
                'to'      => $to->format('Y-m-d'),
            ]
        );

        return ($queryBuilder->getQuery()->getSingleResult(AbstractQuery::HYDRATE_SCALAR_COLUMN)) === 0;
    }
}