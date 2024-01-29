<?php

namespace App\Repository;

use App\Entity\TokenValidation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TokenValidation>
 *
 * @method TokenValidation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TokenValidation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TokenValidation[]    findAll()
 * @method TokenValidation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenValidationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TokenValidation::class);
    }

    public function add(TokenValidation $tokenValidation): void
    {
        $this->_em->persist($tokenValidation);
        $this->_em->flush();
    }

    public function remove(TokenValidation $tokenValidation): void
    {
        $this->_em->remove($tokenValidation);
        $this->_em->flush();
    }
    
//    /**
//     * @return TokenValidation[] Returns an array of TokenValidation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TokenValidation
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
