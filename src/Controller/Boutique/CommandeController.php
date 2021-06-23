<?php

namespace App\Controller\Boutique;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/boutique/commande', name: 'boutique_commande')]
    public function index(): Response
    {
        return $this->render('boutique/commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
}
