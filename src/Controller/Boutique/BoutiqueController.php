<?php

namespace App\Controller\Boutique;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique/boutique', name: 'boutique_boutique')]
    public function index(): Response
    {
        return $this->render('boutique/boutique/index.html.twig', [
            'controller_name' => 'BoutiqueController',
        ]);
    }
}
