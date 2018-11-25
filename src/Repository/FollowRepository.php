<?php

namespace App\Repository;

use App\Entity\Follow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Follow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Follow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Follow[]    findAll()
 * @method Follow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Follow::class);
    }

    public function findOneByTwoTeams($value1, $value2): ?Follow
    {
        //verifie avant les valeur des follower avant de regarder si il y sont dans la bdd
        return $this->createQueryBuilder('f')
            ->andWhere('f.follower = :val1')
            ->andWhere('f.followed = :val2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findByFollowedBy($value)
    {
        //select signifie que l'on va compter combien d'id de team est représenter dans la bdd
        //et alors il va envoyer ca a totalfollowby qui va etre afficher par la suite
        return $this->createQueryBuilder('f')
            ->andWhere('f.followed = :val')
            ->setParameter('val', $value)
            ->select('count(f.followed) as totalFollowedBy')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByFollower($value)
    {
        //inverse de la team qui suit
        return $this->createQueryBuilder('f')
            ->andWhere('f.follower = :val')
            ->setParameter('val', $value)
            ->select('count(f.follower) as totalFollowing')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByFollowerByUserId($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.follower = :val')
            ->setParameter('val', $value)
            ->select('(f.followed) as id')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Follow[] Returns an array of Follow objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Follow
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
