<?php

namespace App\Repository;

use App\Entity\RT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RT|null find($id, $lockMode = null, $lockVersion = null)
 * @method RT|null findOneBy(array $criteria, array $orderBy = null)
 * @method RT[]    findAll()
 * @method RT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RTRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RT::class);
    }

//    /**
//     * @return RT[] Returns an array of RT objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RT
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
