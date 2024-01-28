<?php

namespace App\Repository;

use App\Entity\Consommable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consommable>
 *
 * @method Consommable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consommable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consommable[]    findAll()
 * @method Consommable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsommableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consommable::class);
    }

    public function add(Consommable $consommable): void
    {
        $this->_em->persist($consommable);
        $this->_em->flush();
    }

    public function update(Consommable $consommable): void
    {
        $this->_em->persist($consommable);
        $this->_em->flush();
    }

    public function remove(Consommable $consommable): void
    {
        $this->_em->remove($consommable);
        $this->_em->flush();
    }

    //    /**
    //     * @return Consommable[] Returns an array of Consommable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Consommable
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
