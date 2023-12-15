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




class GestionSejourController extends AbstractController
{
    //obtention des sejours effectif dans le cadre d'une sortie
    #[Route('/sejour/sorties', name: 'app_sejour_sorties')]
    public function sorties(SejourRepository $sejourRepository): Response
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->getUser();

        // Vérifier si l'utilisateur est connecté
        if ($user) {
            // Accéder aux propriétés de l'utilisateur
            $service = $user->getLeService()->getId();

            //recuperation des sejours en cours
            $lesSejours=$sejourRepository->findOnGoingSejour($service);

            //appel de la vue
            return $this->render('sejour/sorties.html.twig', [
                'lesSejours'=>$lesSejours,
                'service'=>$service
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

        //récupération du Sejour 
        $repo=$doctrine->getRepository(Sejour::class);
        $leSejour=$repo->find($id);
       
        //création du form
        $formValiderSejour=$this->createForm(SortieSejourType::class,$leSejour);

        //traiter la requete du form
        $formValiderSejour->handleRequest($request);


        //verification formulaire et changement des données
        if ($formValiderSejour->isSubmitted() && $formValiderSejour->isValid()) {
            //enregistrement des modifications
            $em->persist($leSejour);
            $em->flush();

            //redirection
            return $this->redirectToRoute('app_sejour_sorties');
        }
        return $this->render('sejour/validerSortie.html.twig', [
            'formValiderSejour'=>$formValiderSejour,
        ]);
    }

    //obtenir les sejours d'une date donnée
    #[Route('/sejour/date', name: 'app_sejour_date')]
    public function gestionDateDonnee(SejourRepository $sejourRepository,Request $request): Response
    {

       //date du jour
       $date=new DateTime();

       // Set the timezone to "Europe/Paris"
       $date->setTimezone(new DateTimeZone('Europe/Paris'));

       //récuperation des sejours d'aujourd'hui
       $lesSejours = $sejourRepository->findSejoursDate($date);

       //création du form
       $form=$this->createForm(DateFormType::class);

       //traiter la requete du form
       $form->handleRequest($request);

       //on verifie que le formulaire a été correctement soumis
       if ($form->isSubmitted() && $form->isValid()) {

           //récupération de la date saisie
           $selectedDate = $form->get('Date')->getData();


           $lesSejours = $sejourRepository->findSejoursDate($selectedDate);
       }

       //appel de la vue
       return $this->render('sejour/sejoursEnCours.html.twig', [
           'lesSejours'=>$lesSejours,
           'form'=>$form
       ]);
    }

    //Obtenir les sejours à venir
    #[Route('/sejour/aVenir', name: 'app_sejour_a_venir')]
    public function gestionSejourAVenir(SejourRepository $sejourRepository): Response
    {
        //récuperation des sejours à venir
        $lesSejours = $sejourRepository->findSejoursAVenir();

        //appel de la vue
        return $this->render('sejour/sejourAVenir.html.twig', [
            'lesSejours'=>$lesSejours,
        ]);

    }
}
