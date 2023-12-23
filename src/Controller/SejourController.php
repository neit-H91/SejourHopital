<?php

namespace App\Controller;

use App\Entity\Sejour;
use App\Form\SejourType;
use App\Repository\SejourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sejour')]
class SejourController extends AbstractController
{

    #[Route('/{id}', name: 'app_sejour_show', methods: ['GET'])]
    public function show(Sejour $sejour): Response
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->getUser();

        // Vérifier si l'utilisateur est connecté
        if ($user) {
            // récuperation du service de l'utilisateur
            $service = $user->getLeService()->getId();

            //si le service de l'utilisateur et du sejour sont le même on autorise l'accès aux informations
            if ($service == $sejour->getLeLit()->getLaChambre()->getLeService()->getId()){
                return $this->render('sejour/show.html.twig', [
                    'sejour' => $sejour,
                ]);
            } else {
                return $this->redirectToRoute('app_principale');
            }
        }


        
    }

}
