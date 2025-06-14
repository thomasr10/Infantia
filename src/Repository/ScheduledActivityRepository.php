<?php

namespace App\Repository;

use App\Entity\ScheduledActivity;
use App\Entity\Team;
use App\Entity\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ScheduledActivity>
 */
class ScheduledActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScheduledActivity::class);
    }

       /**
        * @return ScheduledActivity[] Returns an array of ScheduledActivity objects
        */
        public function getTodayProgram(Date $todayDateEntity): array
        {
            return $this->createQueryBuilder('s')
                ->leftJoin('s.activity', 'a')
                ->addSelect('a') // force Doctrine à charger l'activité, pas seulement son proxy
                ->andWhere('s.date = :todayDate')
                ->setParameter('todayDate', $todayDateEntity)
                ->orderBy('s.starting_hour', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

        public function getTodayProgramForTeam(Team $teamEntity, Date $todayDateEntity): array
        {
            return $this->createQueryBuilder('s')
                ->andWhere('s.team = :teamEntity')
                ->andWhere('s.date = :dateEntity')
                ->setParameter('teamEntity', $teamEntity)
                ->setParameter('dateEntity', $todayDateEntity)
                ->getQuery()
                ->getResult()
            ;
        }

    //    public function findOneBySomeField($value): ?ScheduledActivity
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
