<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use DateTimeZone;


class PrincipaleController extends AbstractController
{
    #[Route('/', name: 'app_principale')]
    public function index(): Response
    {
        //date du jour
        $date=new DateTime();

        // Set the timezone to "Europe/Paris"
        $date->setTimezone(new DateTimeZone('Europe/Paris'));

        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->getUser();
        // Vérifier si l'utilisateur est connecté
        if ($user) {
            //appel de la vue
            return $this->render('principale/index.html.twig', [
                        'date'=>$date
                    ]);
        }   else {
            // L'utilisateur n'est pas connecté, rediriger vers la page de connexion par exemple
            return $this->redirectToRoute('app_login');
        }
    }
}
