<?php

namespace App\Repository;

use App\Entity\ChildPresence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChildPresence>
 */
class ChildPresenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChildPresence::class);
    }

       /**
        * @return ChildPresence[] Returns an array of ChildPresence objects
        */
       public function getTodaysPresence($dateEntity): array
       {
           return $this->createQueryBuilder('c')
               ->andWhere('c.date = :dateEntity')
               ->setParameter('dateEntity', $dateEntity)
               ->orderBy('c.id', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?ChildPresence
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
