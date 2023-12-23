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
            'SELECT s.id, l.libelle as lit_libelle, p.nom as patient_nom, s.dateDebut, s.dateFin, s.commentaire, s.estArrive, s.estParti
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

    //fonction qui retourne les sejours actif à une certaine date
    public function findSejoursDate($date, $serviceId)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT s.id, l.libelle as lit_libelle, p.nom as patient_nom, s.dateDebut, s.dateFin, s.commentaire, s.estArrive, s.estParti
            FROM App\Entity\Sejour s
            JOIN s.leLit l
            JOIN s.lePatient p
            JOIN l.laChambre c
            JOIN c.leService service
            WHERE service.id = :serviceId
            AND s.dateDebut <= :date
            AND s.dateFin >= :date
            AND s.estArrive = 1
            AND s.estParti = 0'
        );

        $query->setParameter('serviceId', $serviceId);
        $query->setParameter('date', $date);

        return $query->getResult();
    }

    //fonction qui retourne les séjours à venir
    public function findSejoursAVenir($serviceId){
        //date du jour
        $today=new DateTime();

        // Set the timezone to "Europe/Paris"
        $today->setTimezone(new DateTimeZone('Europe/Paris'));

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT s.id, l.libelle as lit_libelle, p.nom as patient_nom, s.dateDebut, s.dateFin, s.commentaire, s.estArrive, s.estParti
            FROM App\Entity\Sejour s
            JOIN s.leLit l
            JOIN s.lePatient p
            JOIN l.laChambre c
            JOIN c.leService service
            WHERE service.id = :serviceId
            AND s.dateDebut >= :date
            AND s.estArrive = 0
            AND s.estParti = 0'
        );

        $query->setParameter('serviceId', $serviceId);
        $query->setParameter('date', $today);

        return $query->getResult();
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
