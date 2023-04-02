<?php

namespace App\Repository;

use App\Entity\Paiements;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Paiements>
 *
 * @method Paiements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paiements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paiements[]    findAll()
 * @method Paiements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaiementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paiements::class);
    }

    public function save(Paiements $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Paiements $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function nombrePaiementMensuel($year, $month) {

        return $this->createQueryBuilder('p')
                    ->select('SUM(p.montant)')
                    ->Where('YEAR(p.date) = :year')
                    ->setParameter('year', $year)
                    ->andWhere('MONTH(p.date) = :month')
                    ->setParameter('month', $month)
                    ->getQuery()
                    ->getSingleScalarResult(); 
    
    }

    public function findPaiements($page, $limit = 15) {
        $limit = abs($limit);

        $result = [];

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('App\Entity\Paiements', 'a')
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit);

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();
        
        
        if (empty($data)) {
            return $result;
        }

        $pages = ceil($paginator->count() / $limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
        //dd($data);

        return $result;

    }

    public function findPaiementClient($page, $limit = 15, $user = '') {
        $limit = abs($limit);

        $result = [];

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\Paiements', 'u')
            ->andWhere('u.client = :val')
            ->setParameter('val', $user)
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit);

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();
        
        
        if (empty($data)) {
            return $result;
        }

        $pages = ceil($paginator->count() / $limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
        //dd($data);

        return $result;

    }

    public function amountPaiementMensuelClient($year, $month, $user) {

        return $this->createQueryBuilder('p')
                    ->select('SUM(p.montant)')
                    ->Where('YEAR(p.date) = :year')
                    ->setParameter('year', $year)
                    ->andWhere('MONTH(p.date) = :month')
                    ->setParameter('month', $month)
                    ->andWhere('p.client = :val')
                    ->setParameter('val', $user)
                    ->getQuery()
                    ->getSingleScalarResult(); 
    
    }

//    /**
//     * @return Paiements[] Returns an array of Paiements objects
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

//    public function findOneBySomeField($value): ?Paiements
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
