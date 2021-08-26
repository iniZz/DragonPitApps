<?php

namespace App\Repository;

use App\Entity\ApplicationsRejected;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApplicationsRejected|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApplicationsRejected|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApplicationsRejected[]    findAll()
 * @method ApplicationsRejected[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationsRejectedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplicationsRejected::class);
    }

    // /**
    //  * @return ApplicationsRejected[] Returns an array of ApplicationsRejected objects
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
    public function findOneBySomeField($value): ?ApplicationsRejected
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
