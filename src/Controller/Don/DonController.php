<?php

namespace App\Controller\Don;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DonController extends AbstractController
{
    #[Route('/don/don', name: 'don_don')]
    public function index(): Response
    {
        return $this->render('don/don/index.html.twig', [
            'controller_name' => 'DonController',
        ]);
    }
}
