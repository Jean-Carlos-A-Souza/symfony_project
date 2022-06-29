<?php

namespace App\Repository;

use App\Entity\GaleriaItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GaleriaItems>
 *
 * @method GaleriaItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method GaleriaItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method GaleriaItems[]    findAll()
 * @method GaleriaItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GaleriaItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GaleriaItems::class);
    }

    public function add(GaleriaItems $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GaleriaItems $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GaleriaItems[] Returns an array of GaleriaItems objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GaleriaItems
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
