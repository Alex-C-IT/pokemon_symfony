<?php

namespace App\Repository;

use App\Entity\Attaque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Attaque>
 *
 * @method Attaque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attaque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attaque[]    findAll()
 * @method Attaque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttaqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attaque::class);
    }

//    /**
//     * @return Attaque[] Returns an array of Attaque objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Attaque
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
