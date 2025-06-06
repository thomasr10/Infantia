<?php

namespace App\Repository;

use App\Entity\Representative;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Representative>
 */
class RepresentativeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Representative::class);
    }

    //    /**
    //     * @return Representative[] Returns an array of Representative objects
    //     */
       public function getRepresentativeFromUser($user): ?Representative
       {
           return $this->createQueryBuilder('r')
               ->andWhere('r.user_id = :user')
               ->setParameter('user', $user)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }

       public function findOneById($id): ?Representative
       {
           return $this->createQueryBuilder('r')
               ->andWhere('r.id = :id')
               ->setParameter('id', $id)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }
}
