<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SejourRepository;
use App\Entity\Sejour;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SortieSejourType;
use App\Form\DateFormType;
use DateTime;
use DateTimeZone;
use Knp\Component\Pager\PaginatorInterface;

class GestionSejourController extends AbstractController
{
    //obtention des sejours effectif dans le cadre d'une sortie
    #[Route('/sejour/sorties', name: 'app_sejour_sorties')]
    public function sorties(SejourRepository $sejourRepository,Request $request,PaginatorInterface $paginator): Response
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->getUser();

        // Vérifier si l'utilisateur est connecté
        if ($user) {
            // Accéder aux propriétés de l'utilisateur
            $service = $user->getLeService()->getId();

            //recuperation des séjours et pagination
            $pagination=$paginator->paginate(
                $sejourRepository->findOnGoingSejour($service),
                $request->query->get('page',1),
                10
            );

            //appel de la vue
            return $this->render('sejour/sorties.html.twig', [
                'service'=>$service,
                'pagination'=>$pagination
            ]);
        } else {
                // L'utilisateur n'est pas connecté, rediriger vers la page de connexion par exemple
                return $this->redirectToRoute('app_login');
            }

    }

    //Valider la sortie du patient
    #[Route('/sejour/sortie/{id}', name: 'app_valider_sorties')]
    public function valid(ManagerRegistry $doctrine,$id, Request $request,EntityManagerInterface $em): Response
    {
        //date du jour
        $date=new DateTime();

        // Set the timezone to "Europe/Paris"
        $date->setTimezone(new DateTimeZone('Europe/Paris'));

        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->getUser();

        // Vérifier si l'utilisateur est connecté
        if ($user) {
            // récuperation du service de l'utilisateur
            $service = $user->getLeService()->getId();

            //récupération du Sejour 
            $repo=$doctrine->getRepository(Sejour::class);
            $leSejour=$repo->find($id);

            //si le service de l'utilisateur et du sejour sont le même on autorise l'accès aux informations
            if ($service == $leSejour->getLeLit()->getLaChambre()->getLeService()->getId()){
                //création du form
                $formValiderSejour=$this->createForm(SortieSejourType::class,$leSejour);

                //traiter la requete du form
                $formValiderSejour->handleRequest($request);


                // vérification formulaire et changement des données
                if ($formValiderSejour->isSubmitted() && $formValiderSejour->isValid()) {
                    //on définit la date de fin de séjour à la date du jour
                    $leSejour->setDateFin($date);

                    // enregistrement des modifications
                    $em->persist($leSejour);
                    $em->flush();

                    //redirection vers la liste des séjours actuels
                    return $this->redirectToRoute('app_sejour_sorties');
                }

                
           
                }

                //appel de la vue
                return $this->render('sejour/validerSortie.html.twig', [
                    'formValiderSejour'=>$formValiderSejour,
                    'leSejour'=>$leSejour
                ]);
        } else {
            // L'utilisateur n'est pas connecté, rediriger vers la page de connexion par exemple
            return $this->redirectToRoute('app_login');
        }

    }

    //obtenir les sejours d'une date donnée
    #[Route('/sejour/date', name: 'app_sejour_date')]
    public function gestionDateDonnee(SejourRepository $sejourRepository,Request $request,PaginatorInterface $paginator): Response
    {
        //date du jour
        $date=new DateTime('now');

        // Set the timezone to "Europe/Paris"
        $date->setTimezone(new DateTimeZone('Europe/Paris'));

        //changement du format pour la requete 
        $date=$date->format('Y/m/d');

        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->getUser();

        // Vérifier si l'utilisateur est connecté
        if ($user) {
            // récuperation du service de l'utilisateur
            $service = $user->getLeService()->getId();


            //recuperation des séjours et pagination
            $pagination=$paginator->paginate(
                $sejourRepository->findSejoursDate($date,$service),
                $request->query->get('page',1),
                10
            );

            //création du form
            $form=$this->createForm(DateFormType::class);

            //traiter la requete du form
            $form->handleRequest($request);

            //on verifie que le formulaire a été correctement soumis
            if ($form->isSubmitted() && $form->isValid()) {

                //récupération de la date saisie
                $date = $form->get('Date')->getData();

                //recuperation des séjours à la date souhaitée et pagination
                $pagination=$paginator->paginate(
                $sejourRepository->findSejoursDate($date,$service),
                $request->query->get('page',1),
                10
            );
            }
        } else {
            // L'utilisateur n'est pas connecté, rediriger vers la page de connexion par exemple
            return $this->redirectToRoute('app_login');
        }
       //appel de la vue
       return $this->render('sejour/sejoursEnCours.html.twig', [
            'pagination'=>$pagination,
            'form'=>$form,
            'date'=>$date
       ]);
    }
       

    //Obtenir les sejours à venir
    #[Route('/sejour/aVenir', name: 'app_sejour_a_venir')]
    public function gestionSejourAVenir(SejourRepository $sejourRepository,PaginatorInterface $paginator, Request $request): Response
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->getUser();

        // Vérifier si l'utilisateur est connecté
        if ($user) {
            // Accéder aux propriétés de l'utilisateur
            $service = $user->getLeService()->getId();


            //recuperation des séjours à la date souhaitée et pagination
            $pagination=$paginator->paginate(
                $sejourRepository->findSejoursAVenir($service),
                $request->query->get('page',1),
                10
            );

            //libelle du service
            $service = $user->getLeService()->getLibelle();

            //appel de la vue
            return $this->render('sejour/sejourAVenir.html.twig', [
                'pagination'=>$pagination,
                'service' => $service
            ]);
        } else {
                // L'utilisateur n'est pas connecté, rediriger vers la page de connexion par exemple
                return $this->redirectToRoute('app_login');
            }
    }
}
