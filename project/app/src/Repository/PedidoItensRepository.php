<?php

namespace App\Repository;

use App\Entity\PedidoItens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PedidoItens>
 *
 * @method PedidoItens|null find($id, $lockMode = null, $lockVersion = null)
 * @method PedidoItens|null findOneBy(array $criteria, array $orderBy = null)
 * @method PedidoItens[]    findAll()
 * @method PedidoItens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidoItensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PedidoItens::class);
    }

    public function add(PedidoItens $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PedidoItens $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PedidoItens[] Returns an array of PedidoItens objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

   public function findOneById($value): ?PedidoItens
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.id = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
