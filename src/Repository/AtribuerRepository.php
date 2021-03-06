<?php

namespace App\Repository;

use App\Entity\Atribuer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Atribuer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Atribuer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Atribuer[]    findAll()
 * @method Atribuer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtribuerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Atribuer::class);
    }

    /**      
     * @return Atribuer[] Returns an array of Atribuer objects    
     */    
    public function atribuersByCompetence($competence)    
    {        
        return $this->createQueryBuilder('a')            
        ->andWhere('competence.libelle = :competence')            
        ->leftJoin('a.competence', 'competence', 'WITH', )            
        ->setParameter('competence', $competence)            
        ->orderBy('a.id', 'ASC')            
        ->getQuery()            
        ->getResult()        
        ;    
    }

    public function atribuersByUser($user)    
    {        
        return $this->createQueryBuilder('a')            
        ->andWhere('user.idUnique = :user')            
        ->leftJoin('a.user', 'user', 'WITH', )            
        ->setParameter('user', $user)            
        ->orderBy('a.id', 'ASC')            
        ->getQuery()            
        ->getResult()        
        ;    
    }

    // /**
    //  * @return Atribuer[] Returns an array of Atribuer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Atribuer
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
