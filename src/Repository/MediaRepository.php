<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    /**
      * @return Media[] Returns an array of Media objects
      */
    
    public function findByCategoryField($value)
    {
        return $this->createQueryBuilder('m')
            ->join('m.category', 'c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Media
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findExtension($extension, $tri)
    {
        return  $this->createQueryBuilder('m')
                        ->orWhere('m.extension IN(:extension)')
                        ->setParameter('extension', array_values($extension))
                        ->orderBy('m.'.$tri, 'ASC')
                        ->getQuery()
                        ->getResult();
    }

    public function searchNav($name)
    {
        return $this->createQueryBuilder('m')
                    ->andWhere('m.name LIKE :val')
                    ->setParameter('val', '%'.$name.'%')
                    ->getQuery()
                    ->getResult();
    }
}
