<?php

namespace App\Repository;

use App\Entity\ETweet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ETweet|null find($id, $lockMode = null, $lockVersion = null)
 * @method ETweet|null findOneBy(array $criteria, array $orderBy = null)
 * @method ETweet[]    findAll()
 * @method ETweet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ETweetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ETweet::class);
    }

    /**
    //     * @return ETweet[] Returns an array of ETweet objects
    //     */

    public function findByTeamId($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.team = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return ETweet[] Returns an array of ETweet objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ETweet
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
