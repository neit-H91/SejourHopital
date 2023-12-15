<?php

namespace App\Repository;

use App\Entity\Sejour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;
use DateTimeZone;


/**
 * @extends ServiceEntityRepository<Sejour>
 *
 * @method Sejour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sejour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sejour[]    findAll()
 * @method Sejour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SejourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sejour::class);
    }

    //Fonction qui permet d'obtenir les séjours en cours
    public function findOnGoingSejour($service)
    {
        $entityManager=$this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT s.id, l.id as lit_id, p.id as patient_id, s.dateDebut, s.dateFin, s.commentaire, s.estArrive, s.estParti
            FROM App\Entity\Sejour s
            JOIN s.leLit l
            JOIN s.lePatient p
            JOIN l.laChambre c
            JOIN c.leService service
            WHERE s.estParti = 0
            AND s.estArrive = 1
            AND service.id = :serviceId'
        );

        $query->setParameter('serviceId',$service);

        return $query->getResult();

    }

    //fonction qui retourne les sejours à une certaine date
    public function findSejoursDate($date)
    {
        $modifiedDate = clone $date;
    
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateDebut >= :todayStart')
            ->andWhere('s.dateDebut < :tomorrowStart')
            ->andWhere('s.estParti = :estParti')
            ->andWhere('s.estArrive = :isArrive')
            ->setParameter('todayStart', $date->format('Y-m-d 00:00:00'))
            ->setParameter('tomorrowStart', $modifiedDate->modify('+1 day')->format('Y-m-d 00:00:00'))
            ->setParameter('isArrive', 1)
            ->setParameter('estParti', 0)
            ->getQuery()
            ->getResult();
    }

    //fonction qui retourne les séjours à venir
    public function findSejoursAVenir(){
        //date du jour
        $today=new DateTime();

        // Set the timezone to "Europe/Paris"
        $today->setTimezone(new DateTimeZone('Europe/Paris'));

        //recuperation des sejours
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateDebut >=:today')
            ->andWhere('s.estArrive = :isArrive')
            ->andWhere('s.estParti = :estParti')
            ->setParameter('today',$today->format('Y-m-d 00:00:00'))
            ->setParameter('isArrive', 0)
            ->setParameter('estParti', 0)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Sejour[] Returns an array of Sejour objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sejour
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
