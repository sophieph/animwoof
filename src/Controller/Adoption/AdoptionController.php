<?php

namespace App\Controller\Adoption;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdoptionController extends AbstractController
{
    #[Route('/adoption/adoption', name: 'adoption_adoption')]
    public function index(): Response
    {
        return $this->render('adoption/adoption/index.html.twig', [
            'controller_name' => 'AdoptionController',
        ]);
    }
}
