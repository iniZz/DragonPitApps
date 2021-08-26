<?php

namespace App\Repository;

use App\Entity\ApplicationsAccepted;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApplicationsAccepted|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApplicationsAccepted|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApplicationsAccepted[]    findAll()
 * @method ApplicationsAccepted[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationsAcceptedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplicationsAccepted::class);
    }

    // /**
    //  * @return ApplicationsAccepted[] Returns an array of ApplicationsAccepted objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ApplicationsAccepted
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
