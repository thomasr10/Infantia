<?php

namespace App\Repository;

use App\Entity\Child;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Child>
 */
class ChildRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Child::class);
    }

    //    /**
    //     * @return Child[] Returns an array of Child objects
    //     */
       public function getChildrenFromUser(User $user): array
       {
           return $this->createQueryBuilder('c')
               ->andWhere('c.exampleField = :val')
               ->setParameter('val', $value)
               ->orderBy('c.id', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

       public function getAllChildren(): array
       {
            return $this->createQueryBuilder('c')
                ->orderBy('c.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
       }

    //    public function findOneBySomeField($value): ?Child
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
