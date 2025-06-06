<?php

namespace App\Repository;

use App\Entity\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Date>
 */
class DateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Date::class);
    }

    //    /**
    //     * @return Date[] Returns an array of Date objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Date
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getDateEntityFromDays(array $array, \DateTimeInterface $entrance_date): array
    {   
        $endDate = (clone $entrance_date)->modify('+1 year'); // clone pour ne pas modifier l'objet original

        return $this->createQueryBuilder('d')
            ->andWhere('d.day IN (:days)')
            ->andWhere('d.date BETWEEN :entranceDate AND :endDate')
            ->setParameter('days', $array)
            ->setParameter('entranceDate', $entrance_date->format('Y-m-d'))
            ->setParameter('endDate', $endDate->format('Y-m-d'))
            ->getQuery()
            ->getResult()
        ;
    }
}